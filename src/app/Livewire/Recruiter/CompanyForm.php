<?php

namespace App\Livewire\Recruiter;

use App\Models\Company;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class CompanyForm extends Component
{
    use WithFileUploads;

    public ?Company $company = null;

    public string $name = '';

    public $logo;

    public ?string $address = null;

    public ?string $description = null;

    public ?string $website = null;

    public ?string $contact_email = null;

    public ?string $contact_phone = null;

    public function mount(): void
    {
        $this->company = Auth::user()->company;

        if ($this->company) {
            $this->name = $this->company->name;
            $this->address = $this->company->address;
            $this->description = $this->company->description;
            $this->website = $this->company->website;
            $this->contact_email = $this->company->contact_email;
            $this->contact_phone = $this->company->contact_phone;
        }
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:1024'],
            'address' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'website' => ['nullable', 'url', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
        ]);

        $data = $validated;
        unset($data['logo']);

        if ($this->logo) {
            $data['logo_path'] = $this->logo->store('companies/logos', 'public');
        }

        Company::updateOrCreate(
            ['user_id' => Auth::id()],
            $data + [
                'user_id' => Auth::id(),
            ]
        );

        $this->company = Company::query()
            ->where('user_id', Auth::id())
            ->first();

        session()->flash('success', 'Company profile berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.recruiter.company-form');
    }
}