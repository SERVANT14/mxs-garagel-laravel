export function forwardTo (path, waitFor = 1000) {
    window.setTimeout(
        () => window.location.assign(Laravel.appUrl + path),
        waitFor
    )
}
