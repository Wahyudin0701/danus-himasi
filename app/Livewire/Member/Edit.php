<?php

namespace App\Livewire\Member;

use App\Models\User;
use App\Models\Bidang;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Edit extends Component
{
    public User $member;
    public $name;
    public $nim;
    public $angkatan;
    public $jabatan;
    public $email;
    public $password;

    public function mount(User $member)
    {
        abort_if(auth()->user()->role !== 'admin', 403);
        $this->member = $member;
        $this->name = $member->name;
        $this->nim = $member->nim;
        $this->angkatan = $member->angkatan;
        $this->jabatan = $member->jabatan;
        $this->email = $member->email;
    }

    public function getJabatanOptionsProperty()
    {
        $singularRoles = ['Ketua Divisi', 'Wakil Ketua Divisi', 'Sekretaris Divisi', 'Bendahara Divisi'];
        $options = [];

        // Ambil jabatan yang sudah dipakai oleh user LAIN di periode yang sama
        $usedJabatan = User::where('id', '!=', $this->member->id)
                           ->where('periode_id', $this->member->periode_id)
                           ->pluck('jabatan')->toArray();

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
            'name' => 'required|max:255',
            'nim' => 'required|unique:users,nim,'.$this->member->id,
            'angkatan' => 'required|max:10',
            'jabatan' => 'required',
            'password' => 'nullable|min:6',
        ]);

        $singularRoles = ['Ketua Divisi', 'Wakil Ketua Divisi', 'Sekretaris Divisi', 'Bendahara Divisi'];
        $isSingular = in_array($this->jabatan, $singularRoles) || str_starts_with($this->jabatan, 'Ketua Bidang');

        if ($isSingular) {
            $exists = User::where('jabatan', $this->jabatan)
                          ->where('id', '!=', $this->member->id)
                          ->where('periode_id', $this->member->periode_id)
                          ->exists();
            if ($exists) {
                $this->addError('jabatan', "Jabatan '{$this->jabatan}' hanya bisa diisi oleh 1 orang.");
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

        $data = [
            'name' => $this->name,
            'nim' => $this->nim,
            'angkatan' => $this->angkatan,
        ];

        // Jika dia adalah kadiv atau wakadiv dari awal, JANGAN ubah role dan jabatannya (dikunci permanen)
        if (!in_array($this->member->role, ['kadiv', 'wakadiv'])) {
            $data['jabatan'] = $this->jabatan;
            $data['role'] = $role;
            $data['bidang_id'] = $bidang_id;
        }

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $this->member->update($data);

        return redirect()->route('members.index')->with('message', 'Pengurus berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.member.edit')->layout('layouts.app');
    }
}
