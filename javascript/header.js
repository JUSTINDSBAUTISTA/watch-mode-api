
function downloadJson(data = null) {
    let dataToUse = detailsData;

    if (data) {
        dataToUse = JSON.parse(decodeURIComponent(data));
    }   
    if (typeof dataToUse !== 'undefined') {
        // Convert the JSON object to a string and create a Blob
        const blob = new Blob([JSON.stringify(dataToUse, null, 2)], { type: 'application/json' });

        // Create a URL for the Blob and trigger download
        const url = URL.createObjectURL(blob);
        const downloadLink = document.createElement('a');
        downloadLink.href = url;
        downloadLink.download = `${dataToUse.title || 'details'}_details.json`;
        downloadLink.click();

        // Clean up
        URL.revokeObjectURL(url);
    } else {
        console.error("detailsData is not defined.");
    }
}

window.downloadJson = downloadJson;

console.log(document.readyState);