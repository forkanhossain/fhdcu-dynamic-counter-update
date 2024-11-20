document.addEventListener('DOMContentLoaded', function() {
    const counterElement = document.querySelector('.fhdcu-transactions-counter');
    
    if (!counterElement) return; // Exit if the element is not found

    // Parse the formatted string by removing commas for accurate counting
    const targetCount = parseInt(counterElement.getAttribute('data-count').replace(/,/g, ''), 10);
    let count = 1;
    const duration = 2000; // Animation duration in milliseconds
    const increment = Math.ceil(targetCount / (duration / 10)); // Calculate increment per step

    function updateCounter() {
        count += increment;
        if (count > targetCount) count = targetCount;
        counterElement.textContent = count.toLocaleString(); // Format with commas

        if (count < targetCount) {
            setTimeout(updateCounter, 10); // Call function every 10ms
        }
    }

    updateCounter();
});
