function createHeaders(keys) {
    const result = [];
    for (let i = 0; i < keys.length; i += 1) {
        result.push({
            id: keys[i],
            name: keys[i],
            prompt: keys[i],
            width: 65,
            align: "center",
            padding: 0
        });
    }
    return result;
}

var generateData = function(toModify) {
    var result = [];
    for (var i = 0; i < toModify.length; i += 1) {

        toModify[i].place = i.toString();
        for (var key of Object.keys(toModify[i])) {
            toModify[i][key] = toModify[i][key].toString();
        }
    }
    return toModify;
};

const writer = new jsPDF('portrait', 'px','a4');
document.querySelector('.stats-header h5').addEventListener('click', async function (event) {
    let request = new XMLHttpRequest();
    request.open('GET', "/getStatistics", true);
    request.responseType = 'json';

    request.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let response = request.response;
            response = generateData(response);

            console.log(response);

            let headers = createHeaders(["place","username", "starsReceived","solved", "successRate"]);
            let margin = (writer.internal.pageSize.width - 55   *5) / 2;

            writer.table(1, 30, response, headers, {autoSize: true});
            writer.save("statistics.pdf");
        }
    }

    request.send();
});