<?php
$token = get_user_meta(get_current_user_id(), 'autoblog-ai_token', true);
?>


<div class="wrap">
    <div class="flex flex-col space-y-4">
        <div class="space-y-12">

            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Autoblog-AI</h2>

                <?php if(empty($token)): ?>
                    <div class="min-w-sm max-w-md mx-auto mt-10 bg-white shadow-lg rounded-lg overflow-hidden">
                        <!-- Card Header -->
                        <div class="bg-blue-500 text-white p-6">
                            <h2 class="text-2xl font-bold">Token registration</h2>
                        </div>

                        <!-- Card Content -->
                        <div class="p-6">
                            <p>To start generating blog post, you will need to get an API token from <a href="http//localhost" class="~text-blue-600 underline">Autoblog-Ai</a> </p>
                            <p class="mt-4">Get a token on the token page and come set it here</p>
                        </div>

                        <div class="p-6">
                            <div class="">
                                <div class="flex w-full space-x-3">
                                    <input id="autoblog_token" name="autoblog_token" type="password"  class="block grow rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                        <!-- Card Footer -->
                        <div class="bg-gray-100 p-6 flex flex-row-reverse">
                            <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded" id="check_token">
                                Verify token
                            </button>
                        </div>
                    </div>





                <?php else: ?>

                    <div class="min-w-sm max-w-md mx-auto mt-10 bg-white shadow-lg rounded-lg overflow-hidden">
                        <!-- Card Header -->
                        <div class="bg-blue-500 text-white p-6">
                            <h2 class="text-2xl font-bold">Your token is registered</h2>
                        </div>

                        <!-- Card Content -->
                        <div class="p-6">
                            <p>Your token is registered so you can start generating blog posts if you have the required credits</p>
                            <p class="mt-4">If you need to revoke your token you can do so by clicking th ebutton below</p>
                        </div>

                        <!-- Card Footer -->
                        <div class="bg-gray-100 p-6 flex flex-row-reverse">
                            <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded" id="revoke_token">
                                Revoke token
                            </button>
                        </div>
                    </div>


                <?php endif; ?>

            </div>
        </div>
    </div>
