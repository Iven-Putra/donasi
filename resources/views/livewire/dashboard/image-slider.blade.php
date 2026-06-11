@if(count($slides) > 0)
    <div x-data="{
            activeSlide: 0,
            slides: @js($slides),
            interval: null,
            next() {
                this.activeSlide = (this.activeSlide + 1) % this.slides.length;
            },
            prev() {
                this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length;
            },
            startAutoPlay() {
                this.interval = setInterval(() => { this.next(); }, 6000);
            },
            stopAutoPlay() {
                if(this.interval) clearInterval(this.interval);
            }
         }"
         x-init="startAutoPlay()"
         @mouseenter="stopAutoPlay()"
         @mouseleave="startAutoPlay()"
         class="relative w-full h-64 md:h-96 rounded-3xl overflow-hidden border border-gray-150 dark:border-gray-700 shadow-sm group">

        <!-- Slides Wrapper -->
        <div class="relative w-full h-full">
            @foreach($slides as $index => $slide)
                <div x-show="activeSlide === {{ $index }}"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 translate-x-4"
                     x-transition:enter-end="opacity-100 translate-x-0"
                     x-transition:leave="transition ease-in duration-500"
                     x-transition:leave-start="opacity-100 translate-x-0"
                     x-transition:leave-end="opacity-0 -translate-x-4"
                     class="absolute inset-0 w-full h-full"
                     style="display: none;">
                    
                    <!-- Background Image -->
                    <img src="{{ asset('storage/' . $slide['flyer']) }}" class="w-full h-full object-cover" alt="Banner {{ $slide['name'] }}">
                    
                    <!-- Gradient & Text Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-black/10 flex flex-col justify-end p-8 md:p-12">
                        <div class="max-w-xl space-y-2">
                            <span class="inline-flex items-center px-2.5 py-1 bg-indigo-600 text-white text-[10px] md:text-xs font-bold rounded-md uppercase tracking-wider">
                                Program {{ $slide['code'] }}
                            </span>
                            <h2 class="text-2xl md:text-4xl font-extrabold text-white leading-tight">
                                {{ $slide['name'] }}
                            </h2>
                            @if($slide['description'])
                                <p class="text-gray-200 text-xs md:text-sm line-clamp-2 mt-2">
                                    {{ $slide['description'] }}
                                </p>
                            @endif
                            <div class="pt-4">
                                <a href="{{ route('donation-types.details', $slide['id']) }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-100 text-gray-900 text-xs font-bold rounded-lg shadow transition-colors">
                                    Lihat Rincian Penyaluran
                                    <svg class="w-3.5 h-3.5 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Navigation Arrows -->
        <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 p-2 rounded-full bg-white/20 hover:bg-white/40 text-white backdrop-blur-sm transition opacity-0 group-hover:opacity-100 focus:outline-none hidden md:block">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 p-2 rounded-full bg-white/20 hover:bg-white/40 text-white backdrop-blur-sm transition opacity-0 group-hover:opacity-100 focus:outline-none hidden md:block">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>

        <!-- Dots Indicators -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
            @foreach($slides as $index => $slide)
                <button @click="activeSlide = {{ $index }}"
                        :class="activeSlide === {{ $index }} ? 'bg-white w-6' : 'bg-white/40 hover:bg-white/70 w-2'"
                        class="h-2 rounded-full transition-all duration-300 focus:outline-none"></button>
            @endforeach
        </div>

    </div>
@endif
