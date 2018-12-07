const serverList = document.getElementById('server-list');
const infoUrl = serverList.dataset.infoUrl;

Array.from(serverList.querySelectorAll('tr[data-id]')).forEach(row => {
    fetch(infoUrl.replace('__ID__', row.dataset.id))
        .then(response => {
            return response.ok
                ? response.json()
                : response.json().then(result => Promise.reject(result));
        })
        .then(result => {
            row.querySelector('[data-cell="hostname"]').textContent = result.hostname;
            row.querySelector('[data-cell="map"]').textContent      = result.map;
            row.querySelector('[data-cell="players"]').textContent  = result.numplayers + '/' + result.maxplayers;
        })
        .catch(result => {
            row.querySelector('[data-cell="hostname"]').textContent = result.error.message;
        });
});
