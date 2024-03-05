<x-app-layout>
    <header class="h-screen bg-gradient-to-b from-blue-300 to-gray-100 dark:from-gray-600 dark:to-gray-900">
        <div class="container mx-auto sm:px-4 py-16 text-center">
                <span class="text-2xl">{{ config('app.name') }}</span></h1>
                <x-text-input type="text" name="query" id="search" placeholder="SEARCH YOUR BEST CLOTHES"
                    class="w-[24rem] sm:w-full max-w-md mx-auto" :value="request('query')" />
            </form>
        </div>
    </header>
    <div class="-mt-96 pb-10">
        <x-card>
            @if ($products->total() > 0)
                <div class="grid gap-2 grid-cols-2 content-center sm:gap-4 md:grid-cols-4">
                    @foreach ($products as $product)
                        <div
                            class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 duration-200 transition-all ring-offset-2 dark:border-gray-700 hover:ring-2 hover:ring-blue-600">
                            <a href="{{ route('product.show', $product) }}">
                                <img class="rounded-t-lg" src="{{ Storage::url($product->image) }}"
                                    alt="{{ $product->name }}" />
                                <div class="p-5 grid content-between h-fit">
                                    <a href="{{ route('product.show', $product) }}">
                                        <h5
                                            class="mb-2 text-sm sm:text-base tracking-tight text-gray-900 dark:text-white">
                                            {{ $product->name }}</h5>
                                    </a>
                                    <span class="text-lg text-black dark:text-gray-400 font-extrabold"><x-idr
                                            :value="$product->price" /></span>
                                    {{-- <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $product->description }}</p> --}}
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="text-center text-gray-600 my-10">
                        <h1 class="text-2xl">Product Not Found</h1>
                    </div>

            @endif
    </div>
    <div class="mt-2">
        {{ $products->links() }}
    </div>
    </x-card>

    </div>


</x-app-layout>
