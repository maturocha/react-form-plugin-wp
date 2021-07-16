import FormikWizard from 'formik-wizard'
import React from 'react'

import steps from '../components/subscription-form/steps'

import {formContainer, Navigation, NextButton, PrevButton,MessageBox, Loader} from '../components/subscription-form/elements/layout';

import fetchWP from '../utils/fetchWP';

function FormWrapper({
  children,
  isLastStep,
  status,
  goToPreviousStep,
  canGoBack,
  actionLabel,
  isSubmitting
}) {
  return (
    <div>
      {children}
      {(isSubmitting || (isLastStep && status)) &&
        <Loader type='spinningBubbles' color='#2c8b9630' heigth={32} width={32} />
      }
      {status &&
        <MessageBox>
          {status.message}
        </MessageBox>
      }
      <Navigation>
        <NextButton className="qbutton" type={(isLastStep) ? 'submit' : ''}>
          <span className="fa fa-check"></span> {actionLabel || (isLastStep ? window.strings.button.finish : window.strings.button.next)}
        </NextButton>
        {canGoBack &&
          <PrevButton className="linkPrevious"  onClick={goToPreviousStep}>
              <span className="fa fa-arrow-left"></span> {window.strings.button.back}
          </PrevButton>}

      </Navigation>
    </div>
  )
}

function App({wpInfo}) {

  const handlerWP = new fetchWP({
    restURL: wpInfo.api_url,
    restNonce: wpInfo.api_nonce,
  });

  const handleSubmit = React.useCallback((values) => {

    let params = {...values};

    let final = {
      locale:  wpInfo.locale,
      sku: wpInfo.plan.sku
    }
    params.final = final;


    handlerWP.post( 'create-subscription', { params } )
    .then(
      (response) => {
        window.location.href = response.value.redirect;
      },
      (err) => console.log('error', err)
    );

    return {
      message: window.strings.messages.welcome,
    }
  }, [])

  return (
    <FormikWizard steps={steps} onSubmit={handleSubmit} render={FormWrapper} />
  )
}

export default App