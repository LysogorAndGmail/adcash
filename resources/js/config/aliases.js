const path = require('path');

module.exports = {
    '@services': path.join(__dirname, '../common/services'),
    '@components': path.join(__dirname, '../components'),
    '@http': path.join(__dirname, '../common/services/http.service.js'),
    '@store': path.join(__dirname, '../store/modules'),
    '@': path.join(__dirname, '../')
};
