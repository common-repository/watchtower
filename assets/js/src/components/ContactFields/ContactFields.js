import { Component } from '@wordpress/element';

class ContactFields extends Component {
    constructor( props ) {
        super( props );

        // Give each contact a unique ID.
        const contacts = props.contacts.map(function(contact){
            contact.id = Math.floor(Math.random() * Date.now());
            return contact;
        });

        this.state = {
            contacts: contacts,
            accountPlan: props.accountPlan
        };
    }

    addContactHandler = ( event ) => {
        event.preventDefault();

        const contact = {
            'id': Math.floor(Math.random() * Date.now()),
            'contact_type_id': 1,
            'endpoint': '',
            'key': '',
            'active': 1,
        }

        const contacts = [ ...this.state.contacts ];
        contacts.push( contact );

        this.setState( { contacts: contacts } );
    }

    changeTypeHandler = ( event, contactID ) => {
        let contacts = [ ...this.state.contacts ];

        contacts = contacts.map( function( contact ) {
            if ( contact.id == contactID ) {
                contact.contact_type_id = event.target.options[ event.target.selectedIndex ].value;
            }

            return contact;
        } );

        this.setState( { contacts: contacts } );
    }

    changeEndpointHandler = ( event, contactID ) => {
        let contacts = [ ...this.state.contacts ];

        contacts = contacts.map( function( contact ) {
            if ( contact.id == contactID ) {
                contact.endpoint = event.target.value;
            }

            return contact;
        } );

        this.setState( { contacts: contacts } );
    }

    changeActiveHandler = ( event, contactID ) => {
        let contacts = [ ...this.state.contacts ];

        contacts = contacts.map( function( contact ) {
            if ( contact.id == contactID ) {
                contact.active = event.target.checked ? 1 : 0;
            }

            return contact;
        } );

        this.setState( { contacts: contacts } );
    }

    deleteContactHandler = ( event, contactID ) => {
        event.preventDefault();

        let contacts = [ ...this.state.contacts ];

        contacts = contacts.filter(function(contact){
            return contact.id != contactID;
        });

        this.setState( { contacts: contacts } );
    }

    getSaveData = () => {
        let contacts = [ ...this.state.contacts ];
        
        contacts = contacts.map( function ( contact ) {
            let saveContact = { ...contact };
            // We don't need the ID as it's specific to the UI and not API.
            delete saveContact.id;
            return saveContact;
        } );

        return contacts;
    }

    renderContactFields = () => {
        return this.state.contacts.map( ( contact, index ) => {
            const description = contact.contact_type_id == 2 ? (
                <p class="description">Phone numbers should be in the format of +15556667777</p>
            ) : null;

            const smsDisabled = this.state.accountPlan == 'basic' ? true : false;
            const smsLabel = this.state.accountPlan == 'basic' ? 'SMS (Pro only)' : 'SMS';
            const contactActive = contact.active ? true : false;

            return (
                <tr>
                    <th>Contact { index + 1 }</th>
                    <td>
                        <select name="contact_type_id[]" onChange={ ( event ) => { this.changeTypeHandler( event, contact.id ) } }>
                            <option value="1" selected={contact.contact_type_id == 1}>Email</option>
                            <option value="2" selected={contact.contact_type_id == 2} disabled={ smsDisabled }>{ smsLabel }</option>
                        </select>
                        <input type="text" name="endpoint[]" onChange={ ( event ) => { this.changeEndpointHandler( event, contact.id ) } } value={ contact.endpoint } className="regular-text" />
                        <br />
                        <fieldset style={{ marginTop: '5px' }}>
                            <label for="enabled">
                                <input name="active[]" type="checkbox" id="enabled" value="1" onChange={ ( event ) => { this.changeActiveHandler( event, contact.id ) } } defaultChecked={ contactActive } />
                                Enabled
                                (or <a href="#delete" onClick={(event) => { this.deleteContactHandler( event, contact.id ) }} style={{ color: 'red'}}>Delete</a>)
                            </label>
                        </fieldset>
                        { description }
                        <input type="hidden" name="key[]" value={ contact.key } />
                    </td>
                </tr>
            );
        } );
    }

    render() {
        return (
            <div>
                <table className="form-table" id="contacts">
                    <tbody>
                        { this.renderContactFields() }
                    </tbody>
                </table>
                <button onClick={ (event) => { this.addContactHandler( event ) } } className="button">+ Add New Contact</button>
                <form method="post">
                    <input type="hidden" name="watchtower_nonce" value={ this.props.nonce } />
                    <input type="hidden" name="watchtower_contacts" value={ JSON.stringify( this.getSaveData() ) } />
                    <p className="submit"><input type="submit" className="button button-primary" value="Save Changes" /></p>
                </form>
            </div>
        );
    }
}

export default ContactFields;
