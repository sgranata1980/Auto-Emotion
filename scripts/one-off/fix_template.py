"""One-off fix (already applied): patch the `page-no-title` block template
so its post-content layout is "default" instead of "constrained". This is
the root-cause fix for the 645px width bug — full-bleed content (like
.hero-media) needs the ancestor to not clip to the constrained width. Kept
for reference — running it again is idempotent.

Requires WP_USER / WP_APP_PASSWORD, see .env.example.
"""

import json
import urllib.request
import urllib.error
import sys
import os

sys.path.insert(0, os.path.join(os.path.dirname(__file__), ".."))
from _wp_client import BASE, auth_header

NEW_TEMPLATE = (
    '<!-- wp:template-part {"slug":"header","theme":"twentytwentyfive"} /-->\n\n'
    '<!-- wp:group {"tagName":"main","style":{"spacing":{"margin":{"top":"0"}}}} -->\n'
    '<main class="wp-block-group" style="margin-top:0">\n'
    '\t<!-- wp:post-content {"lock":{"move":false,"remove":true},"layout":{"type":"default"}} /-->\n'
    '</main>\n'
    '<!-- /wp:group -->\n\n'
    '<!-- wp:template-part {"slug":"footer","theme":"twentytwentyfive"} /-->'
)

if __name__ == "__main__":
    payload = {"slug": "page-no-title", "theme": "twentytwentyfive", "content": NEW_TEMPLATE}
    data = json.dumps(payload).encode("utf-8")
    req = urllib.request.Request(
        f"{BASE}/wp-json/wp/v2/templates",
        data=data,
        method="POST",
        headers={"Content-Type": "application/json; charset=utf-8", **auth_header()},
    )
    try:
        with urllib.request.urlopen(req) as resp:
            body = json.loads(resp.read().decode("utf-8"))
            print("STATUS", resp.status, "ID", body.get("id"))
    except urllib.error.HTTPError as e:
        print("HTTP ERROR", e.code)
        print(e.read().decode("utf-8"))
