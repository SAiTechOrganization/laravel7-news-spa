import axios from 'axios';

const resource = 'comments';
const client = axios.create({
    baseURL: '/api',
});

export default {
    store(data) {
        return client.post(resource, data);
    },
    destroy(id) {
        return client.delete(`${resource}/${id}`);
    },
};
