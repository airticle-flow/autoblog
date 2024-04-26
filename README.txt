=== Autoblog-ai ===
Contributors: @airticleflow
Tags: artificial intelligence, chat-gpt, stable diffusion, autoblog
Requires at least: 4.7
Tested up to: 6.5
Stable tag: 1.0.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
This plugin allow to fetch articles from projects generated on AIrticle-flow website and automatically publish them.

The API of AIrticleflow is used in the following way:

User Information Route (/user):

Purpose: Retrieves the authenticated user's information.
Method & Endpoint: GET /user
Functionality: When this endpoint is accessed, it returns the authenticated user's data. This is useful in the plugin to identify the current user.

User Projects Route (/projects):

Purpose: Fetches all the projects associated with the authenticated user.
Method & Endpoint: GET /projects
Functionality: This endpoint fetches data from the Project model where the user_id matches the authenticated user's ID. It's used in the plugin to display all projects owned by the user.

Project Articles Route (/projects/{projectId}/articles):

Purpose: Retrieves articles related to a specific project, owned by the authenticated user.
Method & Endpoint: GET /projects/{projectId}/articles
Functionality:
First, it finds the project by projectId. If the project belongs to the user, it retrieves articles associated with this project where the status is 'created'.

AIrticle-flow.com is a SaaS product that allow generation of quality blog post using artificial intelligence technologies. Terms of use are available at the following page: https://airticle-flow.com/terms-of-use
The privacy policy of AIrticle-flow can be accessed at this address: https://airticle-flow.com/privacy-policy
