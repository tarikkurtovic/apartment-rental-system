var Utils = {
  parseJwt: function(token) {
    if (!token) return null;
    try {
      const base64Url = token.split('.')[1];
      const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
      const jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
      }).join(''));
      return JSON.parse(jsonPayload);
    } catch (e) {
      return null;
    }
  },

  getCurrentUser: function() {
    const token = localStorage.getItem(Constants.TOKEN_KEY);
    const payload = Utils.parseJwt(token);
    return payload ? payload.user : null;
  },

  isAdmin: function() {
    const user = Utils.getCurrentUser();
    return user && user.role === Constants.ROLE_ADMIN;
  },

  isLoggedIn: function() {
    return !!localStorage.getItem(Constants.TOKEN_KEY);
  }
};