// Common JavaScript utility functions
function getWindowSize(inAxis){
    if(window.innerWidth != null) {
        if (inAxis.toLowerCase() == 'width') {
            return window.innerWidth;
        } else if (inAxis.toLowerCase() == 'height') {
            return window.innerHeight;
        } else {
            return -1;
        }
    } else {
        if (inAxis.toLowerCase() == 'width') {
            return document.documentElement.clientWidth;
        } else if (inAxis.toLowerCase() == 'height') {
            return document.documentElement.clientHeight;
        } else {
            return -1;
        }
    }
}

function getScrollPosition(inAxis){      
    if (document.all) {
        if (inAxis.toLowerCase() == 'x') {
            if (!document.documentElement.scrollLeft)
                return document.body.scrollLeft;
            else
                return document.documentElement.scrollLeft;
        } else if (inAxis.toLowerCase() == 'y') {
            if (!document.documentElement.scrollTop)
                return document.body.scrollTop;
            else
                return document.documentElement.scrollTop;
        } else {
            return -1;
        }
    } else {
        if (inAxis.toLowerCase() == 'x') {    
            return window.pageXOffset;
        } else if (inAxis.toLowerCase() == 'y') {
            return window.pageYOffset;
        } else {
            return -1;
        }
    }
}


