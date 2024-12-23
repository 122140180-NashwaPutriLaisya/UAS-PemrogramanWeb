// cookieUtils.js

/**
 * Set a cookie with a specified name, value, and expiration days.
 * @param {string} name - The name of the cookie.
 * @param {string} value - The value of the cookie.
 * @param {number} [days] - Number of days until the cookie expires. If omitted, the cookie is a session cookie.
 */
export function setCookie(name, value, days) {
    let expires = "";
    if (days) {
      const date = new Date();
      date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
      expires = `; expires=${date.toUTCString()}`;
    }
    document.cookie = `${name}=${encodeURIComponent(value)}${expires}; path=/`;
  }
  
  /**
   * Get the value of a cookie by name.
   * @param {string} name - The name of the cookie.
   * @returns {string|null} The value of the cookie, or null if the cookie does not exist.
   */
  export function getCookie(name) {
    const nameEQ = `${name}=`;
    const cookies = document.cookie.split(';');
    for (let i = 0; i < cookies.length; i++) {
      let cookie = cookies[i].trim();
      if (cookie.indexOf(nameEQ) === 0) {
        return decodeURIComponent(cookie.substring(nameEQ.length));
      }
    }
    return null;
  }
  
  /**
   * Delete a cookie by name.
   * @param {string} name - The name of the cookie.
   */
  export function deleteCookie(name) {
    document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
  }  