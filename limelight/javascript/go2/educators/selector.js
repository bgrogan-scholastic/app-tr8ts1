function loadArchivePage(inSelector) {
    if (inSelector.value) {
        document.location="/page?<?php echo GI_TEMPLATENAME; ?>=/educators/browse"+inSelector.name+".html&<?php echo GI_ASSETTYPE; ?>="+inSelector.value;
    }
}

