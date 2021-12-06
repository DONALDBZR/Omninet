// Request Server Attention function
function requestServerAttention(clickedButton) {
    const itemId = clickedButton;
    document.cookie = "itemId=" + itemId;
}
