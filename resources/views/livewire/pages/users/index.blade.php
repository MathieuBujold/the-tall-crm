<div>
    @livewire('pages.users.index-modal')
    <div class="w-full">    
        <flux:table :paginate="$this->users">
            <flux:table.columns>
                <flux:table.column>
                    {{ __('Name') }}
                </flux:table.column>
                <flux:table.column>
                    {{ __('Email') }}
                </flux:table.column>
                <flux:table.column>
                    {{ __('Enabled') }}
                </flux:table.column>
                <flux:table.column>
                    {{ __('Actions') }}
                </flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->users as $singleUser)
                    <flux:table.row>
                        <flux:table.cell>{{ $singleUser->name }}</flux:table.cell>
                        <flux:table.cell>{{ $singleUser->email }}</flux:table.cell>
                        <flux:table.cell>{{ $singleUser->enabled ? __('Yes') : __('No') }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:button variant="primary" wire:click="$dispatch('editUser',{userId: {{ $singleUser->id }}})">{{ __('Edit') }}</flux:button>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>
