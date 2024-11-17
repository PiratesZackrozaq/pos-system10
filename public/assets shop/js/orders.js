document.addEventListener('alpine:init', () => {
    Alpine.data('orderApp', () => ({
        productQuantity: 1,
        customer: {
            name: '',
            phone: '',
            email: ''
        },

        init() {
            alertify.set('notifier', 'position', 'top-right');
        },

        incrementQuantity(prodId) {
            this.productQuantity++;
            this.quantityIncDec(prodId, this.productQuantity);
        },

        decrementQuantity(prodId) {
            if (this.productQuantity > 1) {
                this.productQuantity--;
                this.quantityIncDec(prodId, this.productQuantity);
            }
        },

        quantityIncDec(prodId, qty) {
            axios.post('/orders-code', {
                productIncDec: true,
                product_id: prodId,
                quantity: qty
            }).then(response => {
                const res = response.data;
                if (res.status === 200) {
                    alertify.success(res.message);
                    this.reloadProductContent();
                } else {
                    alertify.error(res.message);
                    this.reloadProductContent();
                }
            }).catch(error => {
                alertify.error('Error updating quantity');
            });
        },

        reloadProductContent() {
            document.getElementById('productContent').load('/ #productContent');
        },

        proceedToPlace() {
            const cphone = this.customer.phone;
            const payment_mode = document.getElementById('payment_mode').value;

            if (!payment_mode) {
                Swal.fire("SELECT PAYMENT METHOD", "SELECT YOUR PAYMENT METHOD", "warning");
                return;
            }

            if (!cphone || !/^\d+$/.test(cphone)) {
                Swal.fire("ENTER PHONE NUMBER", "ENTER VALID PHONE NUMBER", "warning");
                return;
            }

            axios.post('/orders-code', {
                proceedToPlaceBtn: true,
                cphone: cphone,
                payment_mode: payment_mode
            }).then(response => {
                const res = response.data;
                if (res.status === 200) {
                    window.location.href = "/orders-summary";
                } else if (res.status === 404) {
                    Swal.fire({
                        title: res.message,
                        text: res.message,
                        icon: res.status_type,
                        showCancelButton: true,
                        confirmButtonText: "Add Customer",
                    }).then(result => {
                        if (result.isConfirmed) {
                            document.getElementById('addCustomerModal').showModal();
                        }
                    });
                } else {
                    Swal.fire(res.message, res.message, res.status_type);
                }
            });
        },

        addCustomer() {
            const { name, phone, email } = this.customer;

            if (name && phone && /^\d+$/.test(phone)) {
                axios.post('/orders-code', {
                    saveCustomerBtn: true,
                    name: name,
                    phone: phone,
                    email: email
                }).then(response => {
                    const res = response.data;
                    Swal.fire(res.message, res.message, res.status_type);
                    if (res.status === 200) {
                        document.getElementById('addCustomerModal').close();
                    }
                }).catch(() => {
                    Swal.fire("Error", "Please fill all required fields!", "warning");
                });
            } else {
                Swal.fire("Error", "Please fill all required fields!", "warning");
            }
        },

        printBillingZone() {
            const printContent = document.getElementById("myBillingZone").innerHTML;
            const printWindow = window.open("", "", "width=800,height=600");
            printWindow.document.write(`<html><body>${printContent}</body></html>`);
            printWindow.document.close();
            printWindow.print();
        },

        downloadPDF(invoiceNo) {
            const elementHTML = document.querySelector("#myBillingZone");
            const docPDF = new jsPDF();
            docPDF.html(elementHTML, {
                callback: () => {
                    docPDF.save(`${invoiceNo}.pdf`);
                },
                x: 15,
                y: 15,
                width: 170,
                windowWidth: 650
            });
        }
    }));
});
