import { render } from '@wordpress/element';
import ContactFields from './components/ContactFields';

/**
 * Localized data
 */
import { contacts, accountPlan, nonce } from 'watchtowerContacts';

render( <ContactFields contacts={ contacts } accountPlan={ accountPlan } nonce={ nonce } />, document.querySelector( 'div#watchtower-contacts' ) );
