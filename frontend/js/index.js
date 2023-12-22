'use strict'

import { createContacts, deleteContacts, getAllContacts, updateContacts } from "./main.js"

$("#telephone, #telephone-edit").mask("(00) 0000-0000");
$("#cellphone, #cellphone-edit").mask("(00) 00000-0000");

const registerButton = document.getElementById('register-button')

registerButton.addEventListener('click', () => {

    const name = document.getElementById('name')
    const dateOfBirth = document.getElementById('dateOfBirth')
    const email = document.getElementById('email')
    const profession = document.getElementById('profession')
    const telephone = document.getElementById('telephone')
    const cellPhone = document.getElementById('cellphone')
    let checkboxWhatsapp = document.getElementById('checkbox-whatsapp')
    let checkboxEmail = document.getElementById('checkbox-email')
    let checkboxSms = document.getElementById('checkbox-sms')

    if (checkboxWhatsapp.checked) {
        checkboxWhatsapp = 1
    } else {
        checkboxWhatsapp = 0
    }

    if (checkboxEmail.checked) {
        checkboxEmail = 1
    } else {
        checkboxEmail = 0
    }

    if (checkboxSms.checked) {
        checkboxSms = 1
    } else {
        checkboxSms = 0
    }

    if (name.value == "" || name.value == null || dateOfBirth.value == "" || dateOfBirth.value == null || email.value == "" || email.value == null ||
        profession.value == "" || profession.value == null || telephone.value == "" || telephone.value == null || cellPhone.value == "" || cellPhone.value == null) {

        Swal.fire({
            title: "Informação",
            text: "Campos obrigatórios não foram preenchidos.",
            icon: "info"
        });

    } else {

        const dadosContatosJSON = {
            nome: name.value,
            data_nascimento: dateOfBirth.value,
            email: email.value,
            profissao: profession.value,
            telefone: telephone.value,
            celular: cellPhone.value,
            numero_whatsapp: checkboxWhatsapp,
            notificacao_email: checkboxEmail,
            notificacao_sms: checkboxSms,
        }

        createContacts(dadosContatosJSON)

        Swal.fire({
            icon: "success",
            title: "Contato criado com sucesso!",
            showConfirmButton: false
        });

        setTimeout(function () {
            location.reload()
        }, 1500)

    }

})

const formatDate = (date) => {

    let dataObj = new Date(date);

    let dia = dataObj.getDate() + 1;

    let mes

    if (dataObj.getMonth() > 8) {
        mes = dataObj.getMonth() + 1;
    } else {
        mes = "0" + (dataObj.getMonth() + 1);
    }

    let ano = dataObj.getFullYear();

    return dia + "/" + mes + "/" + ano;

}

const contato = await getAllContacts()

const getContatos = (contato) => {

    const bodyTable = document.createElement('tr')
    bodyTable.classList.add('body-table')

    const name = document.createElement('td')
    name.textContent = contato.nome

    const dateOfBirth = document.createElement('td')
    dateOfBirth.textContent = formatDate(contato.data_nascimento)

    const email = document.createElement('td')
    email.textContent = contato.email

    const cellPhone = document.createElement('td')
    cellPhone.textContent = contato.celular

    const containerActions = document.createElement('td')
    containerActions.classList.add('actions')

    const editContact = document.createElement('img')
    editContact.src = './img/editar.png'
    editContact.alt = 'Imagem editar'
    editContact.setAttribute("data-bs-toggle", "modal")
    editContact.setAttribute("data-bs-target", "#editModal")
    editContact.addEventListener('click', () => {

        const name = document.getElementById('name-edit')
        const dateOfBirth = document.getElementById('dateOfBirth-edit')
        const email = document.getElementById('email-edit')
        const profession = document.getElementById('profession-edit')
        const telephone = document.getElementById('telephone-edit')
        const cellPhone = document.getElementById('cellphone-edit')
        let checkboxWhatsapp = document.getElementById('checkbox-whatsapp-edit')
        let checkboxEmail = document.getElementById('checkbox-email-edit')
        let checkboxSms = document.getElementById('checkbox-sms-edit')

        name.value = contato.nome
        dateOfBirth.value = contato.data_nascimento
        email.value = contato.email
        profession.value = contato.profissao
        telephone.value = contato.telefone
        cellPhone.value = contato.celular

        if (contato.numero_whatsapp == 1) {
            checkboxWhatsapp.checked = true
        }

        if (contato.notificacao_email == 1) {
            checkboxEmail.checked = true
        }

        if (contato.notificacao_sms == 1) {
            checkboxSms.checked = true
        }

        const buttonEditModal = document.getElementById('buttonEditModal')
        buttonEditModal.addEventListener('click', () => {

            if (checkboxWhatsapp.checked) {
                checkboxWhatsapp = 1
            } else {
                checkboxWhatsapp = 0
            }

            if (checkboxEmail.checked) {
                checkboxEmail = 1
            } else {
                checkboxEmail = 0
            }

            if (checkboxSms.checked) {
                checkboxSms = 1
            } else {
                checkboxSms = 0
            }

            if (name.value == "" || name.value == null || dateOfBirth.value == "" || dateOfBirth.value == null || email.value == "" || email.value == null ||
                profession.value == "" || profession.value == null || telephone.value == "" || telephone.value == null || cellPhone.value == "" || cellPhone.value == null) {

                Swal.fire({
                    title: "Informação",
                    text: "Campos obrigatórios não foram preenchidos.",
                    icon: "info"
                });

            } else {

                const dadosContatosJSON = {
                    nome: name.value,
                    data_nascimento: dateOfBirth.value,
                    email: email.value,
                    profissao: profession.value,
                    telefone: telephone.value,
                    celular: cellPhone.value,
                    numero_whatsapp: checkboxWhatsapp,
                    notificacao_email: checkboxEmail,
                    notificacao_sms: checkboxSms,
                }

                Swal.fire({
                    icon: "success",
                    title: "Contato atualizado com sucesso!",
                    showConfirmButton: false
                });

                updateContacts(dadosContatosJSON, contato.id)

                setTimeout(function () {
                    location.reload()
                }, 1500)

            }

        })

    })

    const exludeContact = document.createElement('img')
    exludeContact.src = './img/excluir.png'
    exludeContact.alt = 'Imagem excluir'
    exludeContact.setAttribute("data-bs-toggle", "modal")
    exludeContact.setAttribute("data-bs-target", "#excludeModal")
    exludeContact.addEventListener('click', () => {

        const buttonExcludeModal = document.getElementById('buttonExcludeModal')
        buttonExcludeModal.addEventListener('click', () => {
            deleteContacts(contato.id)

            Swal.fire({
                icon: "success",
                title: "Contato excluído com sucesso!",
                showConfirmButton: false
            });

            setTimeout(function () {
                location.reload()
            }, 1500)

        })

    })

    containerActions.append(editContact, exludeContact)

    bodyTable.append(name, dateOfBirth, email, cellPhone, containerActions)

    return bodyTable

}

const carregarContatos = () => {
    const card = document.getElementById('body-table')
    const cardsJson = contato.contatos.map(getContatos)
    card.replaceChildren(...cardsJson)
}

carregarContatos()