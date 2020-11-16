window.uJ = (function() {
    class MicroJ {
        tag(selector) {
            return document.querySelector(selector)
        }

        tags(selector) {
            return document.querySelectorAll(selector)
        }

        tag_or_fail(selector) {
            const tag = this.tag(selector)

            if ( !tag ) {
                throw new Error(`Unable to find tag for selector ${selector}`)
            }

            return tag
        }

        btn(selector, handler) {
            const btn = this.tag_or_fail(selector)

            btn.addEventListener('click', (e) => {
                return handler(btn, e)
            })
        }

        input(selector, set = undefined) {
            const input = this.tag_or_fail(selector)

            if ( typeof set === 'undefined' ) {
                return input.value
            }

            input.value = set
        }

        message_container(selector, message = '') {
            const ctr = this.tag_or_fail(selector)

            return (value = undefined) => {
                if ( typeof value === 'undefined' ) {
                    return message
                }

                message = value
                ctr.innerHTML = message
            }
        }
    }

    return new MicroJ()
})()

uJ.btn('#form-reset-button', () => {
    uJ.input('#username-input', '')
    uJ.input('#password-input', '')

    uJ.tags('.product-input').forEach((input) => {
        input.value = ''
    });

    uJ.tags('input[name=shipping-type]').forEach(input => {
        input.checked = false
    })
})

uJ.btn('#form-submit-button', () => {
    const products = uJ.tags('.product-input')

    for ( const product of products ) {
        if ( (!product.value && parseInt(product.value) !== 0) || parseInt(product.value) < 0 ) {
            alert('All products must have a quantity of 0 or more.')
            return;
        }
    }

    if (!uJ.input('#username-input')) {
        alert('Username is required.')
        return;
    }

    if (!uJ.input('#password-input')) {
        alert('Password is required.')
        return;
    }

    let has_checked = false
    
    uJ.tags('input[name=shipping-type]').forEach(input => {
        if (input.checked) {
            has_checked = true
        }
    })

    if ( !has_checked ) {
        alert('Please choose a shipping type.')
        return
    }

    uJ.tag('form').submit()
})
