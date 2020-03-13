function load(path) {
    let link = document.createElement('LINK');
    link.rel = "stylesheet";
    link.href = path;
    
    $("head").append(link);
}

export{load};