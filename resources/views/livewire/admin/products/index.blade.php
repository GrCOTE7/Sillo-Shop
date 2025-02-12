<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\Product;
use Mary\Traits\Toast;
use Livewire\WithPagination;

new #[Layout('components.layouts.admin')] class extends Component {
    use Toast, WithPagination;

    public array $sortBy = [
        'column'    => 'name',
        'direction' => 'asc',
    ];

    public int $perPage = 10;

    public function headers(): array
    {
        return [
            ['key' => 'image', 'label' => __('Image')],
            ['key' => 'name', 'label' => __('Name')],
            ['key' => 'price', 'label' => __('Price incl. VAT'), 'class' => 'text-right'],
            ['key' => 'active', 'label' => __('Active'), 'class' => 'text-center'],
            ['key' => 'quantity', 'label' => __('Quantity'), 'class' => 'text-right']
        ];
    }

    public function deleteProduct(Product $product): void
    {
        $product->delete();
        $this->success(__('Product deleted successfully.'));
    }

    public function with(): array
    {
        return [
            'products' => Product::orderBy(...array_values($this->sortBy))->paginate($this->perPage),
            'headers'  => $this->headers(),
        ];
    }
}; ?>

@section('title', __('Catalog'))
<div>
    <x-header title="{{ __('Catalog') }}" separator progress-indicator>
        <x-slot:actions>
            <x-button icon="s-building-office-2" label="{{ __('Dashboard') }}" class="btn-outline lg:hidden"
                link="{{ route('admin') }}" />
            <x-button icon="o-plus" label="{!! __('Create a new product') !!}" link="/admin/products/create" spinner
                class="btn-primary" />
        </x-slot:actions>
    </x-header>

    <x-card>
        <x-table striped :headers="$headers" :rows="$products" :sort-by="$sortBy" per-page="perPage" with-pagination
            link="/admin/products/{id}/edit">
            @scope('cell_image', $product)
                <img src="{{ asset('storage/photos/' . $product->image) }}" width="60" alt="">
            @endscope

            @scope('cell_price', $product)
                {{ ftA($product->price) }}
            @endscope

            @scope('cell_active', $product)
                @if ($product->active)
                    <x-icon name="o-check-circle" class='text-green-400 w-7' />
                @else
                    <x-icon name="o-x-circle" class='text-orange-400 w-7' />
                @endif
            @endscope

            @scope('cell_quantity', $product)
                <p class="">
                    {{ bigR($product->quantity, 0) }}
                </p>
            @endscope

            @scope('actions', $product)
                <x-popover>
                    <x-slot:trigger>
                        <x-button icon="o-trash" wire:click="deleteProduct({{ $product->id }})"
                            wire:confirm="{{ __('Are you sure you want to delete this product?') }}" spinner
                            class="text-red-500 btn-ghost btn-sm" />
                    </x-slot:trigger>
                    <x-slot:content class="pop-small">
                        @lang('Delete')
                    </x-slot:content>
                </x-popover>
            @endscope
        </x-table>
    </x-card>
</div>
