import { object, string, ref, boolean } from 'yup'

import PersonalInfo from './views/PersonalInfo'
import AddressInfo from './views/AddressInfo'
import FinalStep from './views/FinalStep'

import fetchWP from '../../utils/fetchWP';

const form_container = document.getElementById('fb-subscription-form');
const objectId = form_container.getAttribute('data-object-id');
const wpInfo = window[objectId];

console.log(wpInfo)

export default [
  {
    id: 'personal',
    component: PersonalInfo,
    initialValues: {
      firstname: '',
      lastname: '',
      phone: '',
      email: '',
      password: '',
      passwordConfirmation: '',
    },
    validationSchema: object().shape({
      firstname: string().required(window.strings.messages.required),
      lastname: string().required(window.strings.messages.required),
      phone: string().required(window.strings.messages.required),
      email: string().email().required(window.strings.messages.required),
      password: string().required(window.strings.messages.required).min(8, window.strings.messages.password_validation),
      passwordConfirmation: string().oneOf([ref('password'), null], window.strings.messages.password_match).required(window.strings.messages.required)
    }),
    onAction: async (sectionValues, formValues) => {

      const handlerWP = new fetchWP({
        restURL: wpInfo.api_url,
        restNonce: wpInfo.api_nonce,
      });

      await handlerWP.get( 'email-exists?email=' + sectionValues.email )
      .then(
        (response) => console.log(response),
        (err) => {
          throw new Error(err.message)
        }
      );
    },
  },
  {
    id: 'address',
    component: AddressInfo,
    initialValues: {
      company: '',
      address: '',
      postalCode: '',
      city: ''
    },
    validationSchema: object().shape({
      address: string().required(window.strings.messages.required),
      postalCode: string().required(window.strings.messages.required),
      city: string().required(window.strings.messages.required)
    }),
  },
  
]