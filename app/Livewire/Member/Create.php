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
        $activePeriodeId = optional(Periode::active())->id;
        $singularRoles = ['Ketua Divisi', 'Wakil Ketua Divisi', 'Sekretaris Divisi', 'Bendahara Divisi'];
        $options = [];

        // Check singular roles only within the active periode
        $usedJabatan = User::where('periode_id', $activePeriodeId)->pluck('jabatan')->toArray();

        foreach ($singularRoles as $role) {
            if (!in_array($role, $usedJabatan)) {
                $options[] = ['value' => $role, 'label' => $role, 'disabled' => false];
            }
        }

        foreach (Bidang::all() as $bidang) {
            $ketua = 'Ketua Bidang ' . $bidang->name;
            if (!in_array($ketua, $usedJabatan)) {
                $options[] = ['value' => $ketua, 'label' => $ketua, 'disabled' => false];
            }
            $anggota = 'Anggota Bidang ' . $bidang->name;
            $options[] = ['value' => $anggota, 'label' => $anggota, 'disabled' => false];
        }

        return $options;
    }

    public function save()
    {
        $activePeriodeId = optional(Periode::active())->id;

        $this->validate([
            'name'     => 'required|max:255',
            'nim'      => ['required', \Illuminate\Validation\Rule::unique('users', 'nim')->where('periode_id', $activePeriodeId)],
            'angkatan' => 'required|max:10',
            'jabatan'  => 'required',
            'password' => 'required|min:6',
        ]);

        $singularRoles = ['Ketua Divisi', 'Wakil Ketua Divisi', 'Sekretaris Divisi', 'Bendahara Divisi'];
        $isSingular = in_array($this->jabatan, $singularRoles) || str_starts_with($this->jabatan, 'Ketua Bidang');

        if ($isSingular) {
            $exists = User::where('jabatan', $this->jabatan)->where('periode_id', $activePeriodeId)->exists();
            if ($exists) {
                $this->addError('jabatan', "Jabatan '{$this->jabatan}' hanya bisa diisi oleh 1 orang per periode.");
                return;
            }
        }

        $role = 'anggota';
        $bidang_id = null;

        if ($this->jabatan === 'Ketua Divisi') $role = 'kadiv';
        elseif ($this->jabatan === 'Wakil Ketua Divisi') $role = 'wakadiv';
        elseif ($this->jabatan === 'Sekretaris Divisi') $role = 'sekretaris';
        elseif ($this->jabatan === 'Bendahara Divisi') $role = 'bendahara';
        else {
            foreach (Bidang::all() as $bidang) {
                if ($this->jabatan === 'Ketua Bidang ' . $bidang->name || $this->jabatan === 'Anggota Bidang ' . $bidang->name) {
                    $bidang_id = $bidang->id;
                    break;
                }
            }
        }

        User::create([
            'name'       => $this->name,
            'nim'        => $this->nim,
            'angkatan'   => $this->angkatan,
            'jabatan'    => $this->jabatan,
            'role'       => $role,
            'bidang_id'  => $bidang_id,
            'email'      => $this->email,
            'password'   => Hash::make($this->password),
            'periode_id' => $activePeriodeId,
        ]);

        return redirect()->route('members.index')->with('message', 'Pengurus berhasil ditambahkan!');
    }

    public function render()
    {
        return view('livewire.member.create')->layout('layouts.app');
    }
}
