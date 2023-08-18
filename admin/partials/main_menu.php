<?php
$token = get_user_meta(get_current_user_id(), 'autoblog-ai_token', true);
?>
<div class="wrap">
    <div class="flex flex-col space-y-4">
        <div class="space-y-12">

            <div class="border-b border-gray-900/10 pb-12 flex flex-col space-y-5">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Autoblog-AI</h2>
                <?php if(empty($token)): ?>
                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">No token registered</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>You will need to set up an <a href="<?php  menu_page_url('autoblog-ai-token-settings', true); ?>" class="text-blue-600 underline">API token</a> before you can start generating articles.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endif; ?>
                <p class="mt-1 text-sm leading-6 text-gray-600">Let's configure the posts you want to generate</p>


                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Articles description</label>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Here you should describe the what the articles should be about and give as much explanation about the various posts</p>
                        <div class="mt-2">
                            <textarea id="autoblog-ai-prompt" name="autoblog-ai-prompt" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                        </div>
                        <div class="bg-gray-100 p-6 flex flex-row-reverse">
                            <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded" id="generate_articles">
                                Generate articles
                            </button>
                        </div>
                    </div>

                </div>




            </div>
    </div>
</div>

