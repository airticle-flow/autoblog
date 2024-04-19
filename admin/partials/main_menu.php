<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$token = get_user_meta(get_current_user_id(), 'autoblog-ai_token', true);
?>
<div class="wrap autoblog-ai-wrap autoblog-ai">
    <div class="autoblog-ai-flex-col">
        <div class="autoblog-ai-space-y-12">

            <div class="autoblog-ai-border-b autoblog-ai-flex-col">
                <h2 class="autoblog-ai-text-base">AIrticle-flow</h2>
                <?php if(empty($token)): ?>
                <div class="autoblog-ai-bg-yellow autoblog-ai-flex">
                    <div class="autoblog-ai-flex-shrink">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                </svg>
                            </div>
                    <div class="autoblog-ai-ml-3">
                        <h3 class="autoblog-ai-text-yellow">No token registered</h3>
                        <div class="autoblog-ai-mt-2">
                            <p>You will need to set up an <a href="<?php menu_page_url('airticle-flow-token-settings', true); ?>" class="autoblog-ai-text-blue">API token</a> before you can start generating articles.</p>
                        </div>
                    </div>
                </div>

                <?php endif; ?>
                <div class="autoblog-ai-flex-col-space-y-3">
                    <div class="autoblog-ai-grid">
                        <div class="autoblog-ai-flex-col autoblog-ai-col-span-4">
                            <label>Select your AIrticle-flow project</label>
                            <select id="airticle_projects" class="autoblog-ai-w-full autoblog-ai-rounded"></select>
                        </div>
                    </div>

                    <div class="autoblog-ai-mt-10 autoblog-ai-grid">
                        <div class="autoblog-ai-col-span-4 autoblog-ai-flex-col">
                            <label>Post in a specific category</label>
                            <?php wp_dropdown_categories(array(
                                'hide_empty' => 0,
                                'name' => 'category',
                                'hierarchical' => true,
                                'orderby' => 'name',
                            )) ?>
                        </div>
                    </div>

                    <div class="autoblog-ai-mt-10 autoblog-ai-grid">
                        <div class="autoblog-ai-col-span-full">POST schedule</div>
                        <div class="autoblog-ai-flex-col">
                            <label for="now"><input type="radio" name="schedule" value="now" id="now" checked> Post immediately</label>
                            <label for="draft"><input type="radio" name="schedule" value="draft" id="draft"> Post in draft status</label>
                            <label for="drip"><input type="radio" name="schedule" value="drip" id="drip"> Post periodically</label>
                        </div>
                        <div class="schedule-wrapper autoblog-ai-col-span-full"></div>
                    </div>

                    <div>
                        <button class="autoblog-ai-btn autoblog-ai-mt-10" id="publish-articles">Publish articles</button>
                        <span class="autoblog-d-none autoblog-ai-mt-10" id="publishing-articles">Publishing ...</span>
                    </div>

                </div>




            </div>
    </div>
</div>


