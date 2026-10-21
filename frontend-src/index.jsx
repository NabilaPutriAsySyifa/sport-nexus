import React from 'react';
import { createRoot } from 'react-dom/client';
import FacetedFilterSidebar from './components/FacetedFilterSidebar';
import ProductCard from './components/ProductCard';
import SizeSelector from './components/SizeSelector';
import CartDrawer from './components/CartDrawer';
import CheckoutWizard from './components/CheckoutWizard';

// Expose components globally
window.SportNexus = {
  FacetedFilterSidebar,
  ProductCard,
  SizeSelector,
  CartDrawer,
  CheckoutWizard
};

// Automatic Mount Helpers for CodeIgniter Views
document.addEventListener('DOMContentLoaded', () => {
  // 1. Mount PDP Size & Color Selector
  const pdpMount = document.getElementById('react-pdp-selector');
  if (pdpMount) {
    try {
      const product = JSON.parse(pdpMount.getAttribute('data-product') || '{}');
      const sizes = JSON.parse(pdpMount.getAttribute('data-sizes') || '[]');
      const colors = JSON.parse(pdpMount.getAttribute('data-colors') || '[]');
      const baseUrl = pdpMount.getAttribute('data-base-url') || '';
      
      const root = createRoot(pdpMount);
      root.render(
        <SizeSelector 
          product={product} 
          availableSizes={sizes} 
          availableColors={colors} 
          baseUrl={baseUrl} 
        />
      );
    } catch (e) {
      console.error('Failed to mount React SizeSelector:', e);
    }
  }

  // 2. Mount Shopping Cart
  const cartMount = document.getElementById('react-cart-container');
  if (cartMount) {
    try {
      const baseUrl = cartMount.getAttribute('data-base-url') || '';
      const initialItems = JSON.parse(cartMount.getAttribute('data-items') || '[]');
      const root = createRoot(cartMount);
      root.render(<CartDrawer baseUrl={baseUrl} initialItems={initialItems} />);
    } catch (e) {
      console.error('Failed to mount React CartDrawer:', e);
    }
  }

  // 3. Mount Multi-Step Checkout
  const checkoutMount = document.getElementById('react-checkout-wizard');
  if (checkoutMount) {
    try {
      const baseUrl = checkoutMount.getAttribute('data-base-url') || '';
      const currentUser = JSON.parse(checkoutMount.getAttribute('data-user') || 'null');
      const root = createRoot(checkoutMount);
      root.render(<CheckoutWizard baseUrl={baseUrl} currentUser={currentUser} />);
    } catch (e) {
      console.error('Failed to mount React CheckoutWizard:', e);
    }
  }

  // 4. Mount Faceted Filter Sidebar if container exists
  const filterMount = document.getElementById('react-faceted-filter');
  if (filterMount) {
    try {
      const initialFilters = JSON.parse(filterMount.getAttribute('data-initial-filters') || '{}');
      const currentCategory = filterMount.getAttribute('data-category') || 'all';
      const root = createRoot(filterMount);
      root.render(
        <FacetedFilterSidebar 
          initialFilters={initialFilters} 
          currentCategory={currentCategory}
          onFilterChange={(filters) => {
            console.log('Filters changed:', filters);
          }}
        />
      );
    } catch (e) {
      console.error('Failed to mount React FacetedFilterSidebar:', e);
    }
  }
});
