import Vue from 'vue';
import moment from 'moment';

let formatDate = Vue.filter('formatDate', function (date) {
    if (date !== null) {
        return moment(date).format('DD.MM.YYYY');
    }
    return null;
});

let formatFullMonthDate = Vue.filter('formatFullMonthDate', function (date) {
    if (date !== null) {
        return moment(date).format('LL');
    }
    return null;
});

let formatDateTime = Vue.filter('formatDateTime', function (date) {
    if (date !== null) {
        return moment(date).format('DD.MM.YYYY HH:mm');
    }
    return null;
});

let formatTime = Vue.filter('formatTime', function (date) {
    if (date !== null) {
        return moment(date).format('LT');
    }
    return null;
});

let formatDayString = Vue.filter('formatDayString', function (date) {
    if (date !== null) {
        return moment(date).format('ddd');
    }
    return null;
});

let formatDayInt = Vue.filter('formatDayInt', function (date) {
    if (date !== null) {
        return moment(date).format('D');
    }
    return null;
});

let formatMonth = Vue.filter('formatMonth', function (date) {
    if (date !== null) {
        return moment(date).format('MMMM YYYY');
    }
    return null;
});

let truncate = Vue.filter('truncate', function (value, length) {
    length = length || 15;
    if (!value || typeof value !== 'string') {
        return '';
    }
    if (value.length <= length) {
        return value;
    }
    return value.substring(0, length) + '...';
});

let round = Vue.filter('round', function (value, decimals) {
    if(value > 0 && value !== null) {
        return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
    }
    return 0;
});

export const filters = {
    formatDate,
    formatFullMonthDate,
    formatDateTime,
    formatTime,
    formatDayString,
    formatDayInt,
    formatMonth,
    truncate,
    round
};