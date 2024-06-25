vcl 4.0;

backend default {
    .host = "client";
    .port = "80";
}

sub vcl_recv {
    if (req.method == "PURGE") {
        if (!client.ip ~ purge) {
            return (synth(405, "Not allowed."));
        }
        return (purge);
    }
    return (hash);
}

acl purge {
    "localhost";
    "172.16.0.0/12";
}

sub vcl_backend_response {
    # Respecter les en-têtes Cache-Control envoyés par Symfony
    if (beresp.http.Cache-Control) {
        set beresp.ttl = std.duration(regsub(beresp.http.Cache-Control, ".*max-age=([0-9]+).*", "\1"), 0s);
    } else {
        set beresp.ttl = 5m;
    }
}

sub vcl_deliver {
    if (obj.hits > 0) {
        set resp.http.X-Cache = "HIT";
    } else {
        set resp.http.X-Cache = "MISS";
    }
}
