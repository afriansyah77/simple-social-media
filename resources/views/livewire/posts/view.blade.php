<div>
@if(session()->has('success'))
<div class="bg-green-100 border my-3 border-green-400 text-green-700 dark:bg-green-700 dark:border-green-600 dark:text-green-100 px-4 py-3 rounded relative" role="alert">
  <span class="block sm:inline text-center">{{ session()->get('success') }}</span>
</div>
@endif
@if(session()->has('error'))
<div class="bg-red-100 border my-3 border-red-400 text-red-700 dark:bg-red-700 dark:border-red-600 dark:text-red-100 px-4 py-3 rounded relative" role="alert">
  <span class="block sm:inline text-center">{{ session()->get('error') }}</span>
</div>
@endif
	@forelse($posts as $post)
    <div class="flex flex-col my-5">
            <div class="bg-white shadow-md  rounded-3xl p-4">
                <div class="flex-none lg:flex">
                    <div class=" h-full w-full lg:h-48 lg:w-48   lg:mb-0 mb-3">
                    	@foreach($post->postImages as $image)
                        <img src="{{ url('/storage/' . $image->path) }}"
                            alt="Social" class=" w-full  object-scale-down lg:object-cover  lg:h-48 rounded-2xl" onContextMenu="return false;">
                        @endforeach
                    </div>
                    <div class="flex-auto ml-3 justify-evenly py-2">
                    @if(auth()->user()->role_id === 2 || $post->user->id === auth()->id())
                    	<button
							wire:click="showDeletePostModal({{ $post->id }})"
                            class="flex float-right items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 rounded-lg dark:text-red-600 focus:outline-none focus:shadow-outline-gray"
                            aria-label="Delete"
                            wire:loading.class="bg-gray text-gray-400 "
                          >
                            <svg
                              class="w-5 h-5"
                              aria-hidden="true"
                              fill="currentColor"
                              viewBox="0 0 20 20"
                            >
                              <path
                                fill-rule="evenodd"
                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                clip-rule="evenodd"
                              ></path>
                            </svg>
                          </button> 
                         @endif
                        <div class="flex flex-wrap ">
                            <div class="w-full flex-none text-xs text-blue-700 font-medium ">
                                Posted by {{ $post->user->name }}
                            </div>
                            <h2 class="flex-auto text-lg font-medium">{{ $post->title }}</h2>
                        </div>
                        
                          <p class="mt-3">{{ $post->body }}</p>
                          
                        <div class="flex py-4  text-sm text-gray-600">
                            <div class="flex-1 inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <p class="">@if(!empty($post->location)) {{ $post->location }} @else Unknown @endif</p>
                            </div>
                            <div class="flex-1 inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="">{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="flex p-4 pb-2 border-t border-gray-200 "></div>
                        <div class="flex space-x-3 text-sm font-medium">
                            <div class="flex-auto flex space-x-3">
                                <button
                                    class="mb-2 md:mb-0 bg-white px-5 py-2 shadow-sm tracking-wider border text-gray-600 rounded-full hover:bg-gray-100 inline-flex items-center space-x-2 "
                                    wire:click="incrementLike({{ $post->id }})">
                                    @if($post->userLikes->count())
                                    <span class="text-green-400 hover:text-green-500 rounded-lg">
                                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
								    <path fill="currentColor" d="M23,10C23,8.89 22.1,8 21,8H14.68L15.64,3.43C15.66,3.33 15.67,3.22 15.67,3.11C15.67,2.7 15.5,2.32 15.23,2.05L14.17,1L7.59,7.58C7.22,7.95 7,8.45 7,9V19A2,2 0 0,0 9,21H18C18.83,21 19.54,20.5 19.84,19.78L22.86,12.73C22.95,12.5 23,12.26 23,12V10M1,21H5V9H1V21Z" />
									</svg>
                                    </span>
                                    @else
                                    <span class="text-gray-400 hover:text-gray-500 rounded-lg">
                                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
								    <path fill="currentColor" d="M23,10C23,8.89 22.1,8 21,8H14.68L15.64,3.43C15.66,3.33 15.67,3.22 15.67,3.11C15.67,2.7 15.5,2.32 15.23,2.05L14.17,1L7.59,7.58C7.22,7.95 7,8.45 7,9V19A2,2 0 0,0 9,21H18C18.83,21 19.54,20.5 19.84,19.78L22.86,12.73C22.95,12.5 23,12.26 23,12V10M1,21H5V9H1V21Z" />
									</svg>
                                    </span>
                                    @endif
                                    <span>{{ $post->likes_count }}</span>
                                </button>
                            </div>
                            <button
                                class="mb-2 md:mb-0 bg-gray-900 px-5 py-2 shadow-sm tracking-wider text-white rounded-full hover:bg-gray-800"
                                wire:click="comments({{ $post->id }})"
                                type="button" aria-label="like">{{ $post->comments_count }} Comments</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @empty
        <div class="flex flex-col my-12 md:mt-56 lg:mt-56">
            <div class="bg-white shadow-md  rounded-3xl p-4">
                <div class="flex-none lg:flex">
                    <div class=" h-full w-full lg:h-48 lg:w-48   lg:mb-0 mb-3">
                        <img src="{{ asset('images/no-posts.png') }}"
                            alt="Just a flower" class=" w-full  object-scale-down lg:object-cover  lg:h-48 rounded-2xl">
                    </div>
                    <div class="flex-auto ml-3 justify-evenly py-2">
                        <div class="flex flex-wrap ">
                            
                            <h2 class="flex-auto text-lg text-center font-medium">{{ __('No Posts found..!!!') }}</h2>
                        </div>
                        <p class="mt-3"></p>
                        
                    </div>
                </div>
            </div>
        </div>
        @endforelse
        
        <div class="py-4 mb-2">
	        {{ $posts->links() }}
        </div>
        
       
        @include('elements.comments-post-modal')

        @include('elements.delete-post-modal')
        
</div>
