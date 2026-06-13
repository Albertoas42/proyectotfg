<?php

namespace App\Livewire;

use App\Mail\CodigoVerificacionMail;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfile extends Component
{
    use WithFileUploads;

    public User $user;

    public $isEditing = false;
    public $isVerifying = false;

    public $first_name;
    public $last_name;
    public $course;
    public $bio;
    public $newAvatar;

    public $verificationCode;
    public $generatedCode;
    public $verificationError;

    public $availableCourses = [
        '1º SMR (Sistemas Microinformáticos y Redes)',
        '2º SMR (Sistemas Microinformáticos y Redes)',
        '1º DAM (Desarrollo de Aplicaciones Multiplataforma)',
        '2º DAM (Desarrollo de Aplicaciones Multiplataforma)',
        '1º DAW (Desarrollo de Aplicaciones Web)',
        '2º DAW (Desarrollo de Aplicaciones Web)',
        '1º Bachillerato',
        '2º Bachillerato',
        '1º ESO',
        '2º ESO',
        '3º ESO',
        '4º ESO'
    ];

    public function mount(User $user)
    {
        $this->user = $user;

        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->bio = $user->profile?->bio ?? '';
        $this->course = $user->profile?->course ?? '';

    }

    public function toggleEdit()
    {
        if (Auth::id() !== $this->user->user_id) abort(403);
        $this->isEditing = !$this->isEditing;
    }

    public function saveProfile()
    {
        if (Auth::id() !== $this->user->user_id) abort(403);

        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'course' => 'required|string',
            'bio' => 'nullable|string|max:500',
            'newAvatar' => 'nullable|image|max:1024', // Máximo 1MB
        ]);

        $this->user->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
        ]);

        $avatarPath = $this->user->profile?->avatar_path;
        if ($this->newAvatar) {
            if ($avatarPath && Storage::disk('public')->exists($avatarPath)) {
                Storage::disk('public')->delete($avatarPath);
            }
            $avatarPath = $this->newAvatar->store('avatars', 'public');
        }


        $this->user->profile()->updateOrCreate(
            ['user_id' => $this->user->user_id],
            [
                'bio' => $this->bio,
                'course' => $this->course,
                'avatar_path' => $avatarPath
            ]
        );

        $this->isEditing = false;
        $this->newAvatar = null;
        session()->flash('message', '¡Perfil actualizado correctamente!');
    }


    public function sendVerificationEmail()
    {
        if (Auth::id() !== $this->user->user_id) abort(403);

        $this->generatedCode = rand(100000, 999999);
        session(['email_verification_code' => $this->generatedCode]);

        $this->isVerifying = true;
        $this->verificationError = null;


        Mail::to($this->user->email)->send(new CodigoVerificacionMail($this->generatedCode));

        session()->flash('info', "Se ha enviado un código de seguridad real a tu correo institucional ({$this->user->email}). Revisa tu bandeja de entrada.");
    }

    public function checkVerificationCode()
    {
        if (Auth::id() !== $this->user->user_id) abort(403);

        $savedCode = session('email_verification_code');

        // Comprobamos el código
        if ($this->verificationCode && (int)$this->verificationCode === $savedCode) {


            $this->user->profile()->updateOrCreate(
                ['user_id' => $this->user->user_id],
                ['is_verified' => true]
            );

            $this->user->refresh();

            session()->forget('email_verification_code');
            $this->isVerifying = false;
            $this->verificationCode = '';
            $this->verificationError = null;

            session()->flash('message', '🎉 ¡Enhorabuena! Tu cuenta ha sido verificada con tu correo institucional.');
        } else {
            $this->verificationError = 'El código introducido es incorrecto. Vuelve a comprobarlo.';
        }
    }
    public function changeProductStatus($productId, $newStatus)
    {
        $product = \App\Models\Product::where('product_id', $productId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $product->update([
            'status' => $newStatus
        ]);

        session()->flash('message', "El producto ha sido marcado como " . ($newStatus == 'reserved' ? 'Reservado' : 'Vendido') . ".");
    }

    public function render()
    {
        $averageRating = $this->user->reviewsReceived()->avg('rating') ?? 0;
        $totalReviews = $this->user->reviewsReceived()->count();

        $products = $this->user->products()
            ->where('status', 'available')
            ->latest()
            ->take(3)
            ->get();

        return view('livewire.user-profile', [
            'averageRating' => $averageRating,
            'totalReviews' => $totalReviews,
            'products' => $products
        ]);
    }
}
