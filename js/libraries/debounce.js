/**
 * Adds a debounce function, allowing any function to
 * specify a debounce threshold.
 */
Function.prototype.debounce = function (time) {
    var timer,
        fn = this;
    return function () {
        var that = this,
            args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            fn.apply(that, args);
        }, time || 10);
    };
};