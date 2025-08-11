/**
 * Updates a single sticky date element while scrolling through timeline items.
 * Chooses the timeline item closest to the sticky date position.
 */
(function () {
  const sticky = document.querySelector('.timeline-sticky-date');
  const items = Array.from(document.querySelectorAll('.timeline-item'));
  if (!sticky || items.length === 0) return;

  let currentDate = '';

  /** Extract the date string from an item. */
  function readDateFromItem(item) {
    const dateEl = item.querySelector('.timeline-date');
    return dateEl ? dateEl.textContent.trim() : '';
  }

  /** Update sticky date only if it actually changed */
  function updateStickyDate(newDate) {
    if (newDate && newDate !== currentDate) {
      sticky.textContent = newDate;
      currentDate = newDate;
    }
  }

  /** Find timeline item closest to sticky date position */
  function findClosestItem() {
    const stickyRect = sticky.getBoundingClientRect();
    const stickyCenter = stickyRect.top + stickyRect.height / 2;
    
    let closestItem = null;
    let closestDistance = Infinity;
    
    for (const item of items) {
      const itemRect = item.getBoundingClientRect();
      const itemCenter = itemRect.top + itemRect.height / 2;
      const distance = Math.abs(itemCenter - stickyCenter);
      
      // Only consider items that are at least partially visible
      if (itemRect.bottom > 0 && itemRect.top < window.innerHeight) {
        if (distance < closestDistance) {
          closestDistance = distance;
          closestItem = item;
        }
      }
    }
    
    return closestItem;
  }

  /** Update based on closest item */
  function updateFromClosest() {
    const closestItem = findClosestItem();
    if (closestItem) {
      const date = readDateFromItem(closestItem);
      updateStickyDate(date);
    }
  }

  // Initialize with first item's date
  function initialize() {
    if (items.length > 0) {
      const firstDate = readDateFromItem(items[0]);
      updateStickyDate(firstDate);
    }
    // Update after a short delay to ensure proper positioning
    setTimeout(updateFromClosest, 100);
  }

  // Update on scroll with throttling to prevent too many calls
  let scrollTimeout;
  function handleScroll() {
    if (scrollTimeout) return;
    scrollTimeout = setTimeout(() => {
      updateFromClosest();
      scrollTimeout = null;
    }, 50);
  }

  // Event listeners
  window.addEventListener('scroll', handleScroll, { passive: true });
  window.addEventListener('resize', initialize, { passive: true });
  window.addEventListener('load', initialize, { passive: true });
  document.addEventListener('DOMContentLoaded', initialize, { passive: true });
})();



