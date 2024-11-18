export const formatKES = (amount) => {
    // Convert to number and handle various input types
    const numericAmount = Number(amount);

    // Check if it's a valid number
    if (isNaN(numericAmount)) {
      console.warn('Invalid amount provided to formatKES:', amount);
      return 'KES 0.00';
    }

    return new Intl.NumberFormat('en-KE', {
      style: 'currency',
      currency: 'KES',
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    }).format(numericAmount);
  };

  // Vue 3 Plugin
  export const currencyPlugin = {
    install: (app) => {
      app.config.globalProperties.$formatKES = formatKES;
    }
  };
