/* global window, document */
if (! window._babelPolyfill) {
  require('@babel/polyfill');
}

import React from 'react';
import ReactDOM from 'react-dom';
import SubscriptionForm from './containers/Subscription';

document.addEventListener('DOMContentLoaded', function() {
  const form_container = document.getElementById('fb-subscription-form');
  const objectId = form_container.getAttribute('data-object-id');
  ReactDOM.render(<SubscriptionForm wpInfo={window[objectId]} />, form_container);
});
