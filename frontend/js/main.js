'use strict'

export const getAllContacts = async () => {
    const url = 'http://localhost/alphacode/backend/index.php/contatos'
    const response = await fetch(url)
    const data = response.json()

    return data
}

export const createContacts = async (dadosContato) => {
    const url = "http://localhost/alphacode/backend/index.php/contatos"
    const options = {
        headers: {
            "Content-Type": "application/json",
        },
        method: "POST",
        body: JSON.stringify(dadosContato),
    };

    fetch(url, options)
        .then((response) => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error("Erro ao fazer a solicitação");
            }
        })
        .then((data) => {
            console.log(data);
        })
        .catch((error) => {
            console.error(error);
        });
}

export const updateContacts = async (dadosContato, id) => {
    const url = `http://localhost/alphacode/backend/index.php/contatos/${id}`
    const options = {
        headers: {
            "Content-Type": "application/json",
        },
        method: "PUT",
        body: JSON.stringify(dadosContato),
    };

    fetch(url, options)
        .then((response) => {
            if (response.ok) {

                return response.json();
            } else {
                throw new Error("Erro ao fazer a solicitação");
            }
        })
        .then((data) => {
            console.log(data);
        })
        .catch((error) => {
            console.error(error);
        });
}

export const deleteContacts = async (id) => {
    const url = `http://localhost/alphacode/backend/index.php/contatos/${id}`
    const options = {
        method: 'DELETE'
    }
    fetch(url, options)
}