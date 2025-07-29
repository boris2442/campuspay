   document.addEventListener('DOMContentLoaded', function () {
        tippy('[data-tippy-content]', {
            animation: 'scale',
            duration: [300, 200],
            delay: [150, 50],
            theme: 'material',
            arrow: true,
            placement: 'top',
            offset: [0, 10]
        })
    });