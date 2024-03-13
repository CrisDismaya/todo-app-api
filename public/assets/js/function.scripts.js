
    async function get_province(element, selectedId = 0) {
        try {
            let url = `/province`;
            const { result } = await fetch_data(url);

            const selectElement = $(`#${element}`);
            selectElement.empty().append('<option value="">Select</option>');

            result.forEach(item => {
                const { id, text } = item;
                const option = `<option value="${ id }" ${ id === selectedId ? 'selected' : '' }>${ text }</option>`;
                selectElement.append(option);
            });
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }

    async function get_cities(element, province_id, selectedId = 0) {
        try {
            let url = `/cities/${ province_id }`;
            const { result } = await fetch_data(url);

            const selectElement = $(`#${element}`);
            selectElement.empty().append('<option value="">Select</option>');

            result.forEach(item => {
                const { id, text } = item;
                const option = `<option value="${ id }" ${ id === selectedId ? 'selected' : '' }>${ text }</option>`;
                selectElement.append(option);
            });
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }

    async function get_barangay(element, cities_id, selectedId = 0) {
        try {
            let url = `/barangay/${ cities_id }`;
            const { result } = await fetch_data(url);

            const selectElement = $(`#${element}`);
            selectElement.empty().append('<option value="">Select</option>');

            result.forEach(item => {
                const { id, text } = item;
                const option = `<option value="${ id }" ${ id === selectedId ? 'selected' : '' }>${ text }</option>`;
                selectElement.append(option);
            });
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }

    async function fetch_data(url) {
        try {
            const res = await $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json'
            });
            return res;

        } catch (error) {
            console.error('Error fetch_dataing data:', error);
            throw error; // Re-throw the error for the calling function to handle
        }
    }

    async function store_data(url, data = []) {
        try {

            if (url.charAt(0) === '/') {
                url = url.substring(1);
            }

            let new_url = `/${ localStorage.getItem('prefix') }/${ url }`

            const res = await $.ajax({
                url: new_url,
                type: 'POST',
                dataType: 'json',
                data : data
            });
            return res;

        } catch (error) {
            console.error('Error fetch_dataing data:', error);
            throw error; // Re-throw the error for the calling function to handle
        }
    }
