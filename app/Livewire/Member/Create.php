<?php

namespace App\Livewire\Member;

use App\Models\User;
use App\Models\Periode;
use App\Models\Bidang;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $nim;
    public $angkatan;
    public $jabatan;
    public $email;
    public $password;

    public function mount()
    {
        abort_if(auth()->user()->role !== 'admin', 403);
    }

    public function getJabatanOptionsProperty()
    {
        $singularRoles = ['Ketua Divisi', 'Wakil Ketua Divisi', 'Sekretaris Divisi', 'Bendahara Divisi'];
        $options = [];
        
        $usedJabatan = User::pluck('jabatan')->toArray();

        foreach ($singularRoles as $role) {
            if (!in_array($role, $usedJabatan)) {
                $options[] = [
                    'value' => $role,
                    'label' => $role,
                    'disabled' => false
                ];
            }
        }

        foreach(Bidang::all() as $bidang) {
            $ketua = 'Ketua Bidang ' . $bidang->name;
            if (!in_array($ketua, $usedJabatan)) {
                $options[] = [
                    'value' => $ketua,
                    'label' => $ketua,
                    'disabled' => false
                ];
            }

            $anggota = 'Anggota Bidang ' . $bidang->name;
            $options[] = [
                'value' => $anggota,
                'label' => $anggota,
                'disabled' => false
            ];
        }

        return $options;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required||max:255',
            'nim' => 'required||unique:users,nim',
            'angkatan' => 'required||max:10',
            'jabatan' => 'required|',
'password' => 'required|min:6',
        ]);

        // Uniqueness validation for specific singular roles
        $singularRoles = ['Ketua Divisi', 'Wakil Ketua Divisi', 'Sekretaris Divisi', 'Bendahara Divisi'];
        $isSingular = in_array($this->jabatan, $singularRoles) || str_starts_with($this->jabatan, 'Ketua Bidang');

        if ($isSingular) {
            $exists = User::where('jabatan', $this->jabatan)->exists();
            if ($exists) {
                $this->addError('jabatan', "Jabatan '{$this->jabatan}' hanya bisa diisi oleh 1 orang.");
                return;
            }
        }

        // Determine role & bidang_id based on jabatan
        $role = 'anggota';
        $bidang_id = null;

        if ($this->jabatan === 'Ketua Divisi') $role = 'kadiv';
        elseif ($this->jabatan === 'Wakil Ketua Divisi') $role = 'wakadiv';
        elseif ($this->jabatan === 'Sekretaris Divisi') $role = 'sekretaris';
        elseif ($this->jabatan === 'Bendahara Divisi') $role = 'bendahara';
        else {
            // Find bidang if it's Ketua Bidang or Anggota Bidang
            foreach (Bidang::all() as $bidang) {
                if ($this->jabatan === 'Ketua Bidang ' . $bidang->name || $this->jabatan === 'Anggota Bidang ' . $bidang->name) {
                    $bidang_id = $bidang->id;
                    break;
                }
            }
        }

        User::create([
            'name' => $this->name,
            'nim' => $this->nim,
            'angkatan' => $this->angkatan,
            'jabatan' => $this->jabatan,
            'role' => $role,
            'bidang_id' => $bidang_id,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'periode_id' => optional(Periode::active())->id,
        ]);

        return redirect()->route('members.index')->with('message', 'Pengurus berhasil ditambahkan!');
    }

    public function render()
    {
        return view('livewire.member.create')->layout('layouts.app');
    }
}
