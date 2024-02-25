<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$token = get_user_meta(get_current_user_id(), 'autoblog-ai_token', true);
?>


<div class="wrap autoblog-ai">
    <div class="autoblog-ai-flex autoblog-ai-flex-col autoblog-ai-space-y-4">
        <div class="autoblog-ai-space-y-12">
            <div class="autoblog-ai-border-b autoblog-ai-border-gray-900-10 autoblog-ai-pb-12">
                <h2 class="autoblog-ai-text-base autoblog-ai-font-semibold autoblog-ai-leading-7 autoblog-ai-text-gray-900">Autoblog-AI</h2>


                <?php if(empty($token)): ?>
                    <div class="autoblog-ai-min-w-sm autoblog-ai-max-w-md autoblog-ai-mx-auto autoblog-ai-mt-10 autoblog-ai-bg-white autoblog-ai-shadow-lg autoblog-ai-rounded-lg autoblog-ai-overflow-hidden">
                        <!-- Card Header -->
                        <div class="autoblog-ai-bg-blue-500 autoblog-ai-text-white autoblog-ai-p-6">
                            <h2 class="autoblog-ai-text-2xl autoblog-ai-font-bold">Token registration</h2>
                        </div>

                        <!-- Card Content -->
                        <div class="autoblog-ai-p-6">
                            <p>To import your articles, you will need a token from <a href="https://airticle-flow.com/token" class="autoblog-ai-text-blue-600 autoblog-ai-underline">AIrticle-flow</a> </p>
                            <p class="autoblog-ai-mt-4">Get a token on the token page and come set it here</p>
                        </div>

                        <div class="autoblog-ai-p-6">
                            <div class="">
                                <div class="autoblog-ai-flex autoblog-ai-w-full autoblog-ai-space-x-3">
                                    <input id="autoblog_token" name="autoblog_token" type="password" class="autoblog-ai-w-full autoblog-ai-block autoblog-ai-grow autoblog-ai-rounded-md autoblog-ai-border-0 autoblog-ai-py-1.5 autoblog-ai-text-gray-900 autoblog-ai-shadow-sm autoblog-ai-ring-1 autoblog-ai-ring-inset autoblog-ai-ring-gray-300 autoblog-ai-placeholder-text-gray-400 autoblog-ai-focus-ring-2 autoblog-ai-focus-ring-inset autoblog-ai-focus-ring-indigo-600 autoblog-ai-sm-text-sm autoblog-ai-sm-leading-6">
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="autoblog-ai-bg-gray-100 autoblog-ai-p-6 autoblog-ai-flex autoblog-ai-flex-row-reverse">
                            <button class="autoblog-ai-bg-blue-500 autoblog-ai-hover-bg-blue-600 autoblog-ai-text-white autoblog-ai-font-bold autoblog-ai-py-2 autoblog-ai-px-4 autoblog-ai-rounded" id="check_token">
                                Verify token
                            </button>
                        </div>
                    </div>






                <?php else: ?>

                    <div class="autoblog-ai-min-w-sm autoblog-ai-max-w-md autoblog-ai-mx-auto autoblog-ai-mt-10 autoblog-ai-bg-white autoblog-ai-shadow-lg autoblog-ai-rounded-lg autoblog-ai-overflow-hidden">
                        <!-- Card Header -->
                        <div class="autoblog-ai-bg-blue-500 autoblog-ai-text-white autoblog-ai-p-6">
                            <h2 class="autoblog-ai-text-2xl autoblog-ai-font-bold">Your token is registered</h2>
                        </div>

                        <!-- Card Content -->
                        <div class="autoblog-ai-p-6">
                            <p>You can start importing your articles !!</p>
                            <p class="autoblog-ai-mt-4">If you need to revoke your token you can do so by clicking the button below</p>
                        </div>

                        <!-- Card Footer -->
                        <div class="autoblog-ai-bg-gray-100 autoblog-ai-p-6 autoblog-ai-flex autoblog-ai-flex-row-reverse">
                            <button class="autoblog-ai-bg-red-500 autoblog-ai-hover-bg-red-600 autoblog-ai-text-white autoblog-ai-font-bold autoblog-ai-py-2 autoblog-ai-px-4 autoblog-ai-rounded" id="revoke_token">
                                Revoke token
                            </button>
                        </div>
                    </div>



                <?php endif; ?>

            </div>
        </div>
    </div>
