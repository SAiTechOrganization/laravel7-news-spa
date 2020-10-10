import axios from 'axios';

const resource = 'posts';
const client = axios.create({
    baseURL: '/api',
});

export default {
    all(params) {
        return client.get(resource, params);
    },
    find(id) {
        return client.get(`${resource}/${id}`);
    },
    store(data) {
        return client.post(resource, data);
    },
};
