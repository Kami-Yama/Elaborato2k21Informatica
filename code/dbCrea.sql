create table CLIENTI
(
    id_cliente INT AUTO_INCREMENT NOT NULL primary key,
    email VARCHAR(50) NOT NULL,
    nome VARCHAR(30) NOT NULL,
    cognome VARCHAR(30) NOT NULL,
    password VARCHAR(200) NOT NULL,
    telefono VARCHAR(10) NOT NULL,
    dataRegistrazione TIMESTAMP,
    sospensione BOOLEAN
    
);

create table PRENOTAZIONI(

    id_prenotazione INT AUTO_INCREMENT NOT NULL primary key,
    data_inizio TIMESTAMP DEFAULT NOW(),
    n_ore INT NOT NULL,
    id_cliente INT NOT NULL,
    postazione_pren INT NOT NULL,
    data_pren TIMESTAMP DEFAULT NOW(),
    is_closed BOOLEAN,

    foreign key(id_cliente) references CLIENTI (id_cliente)
    
);


create table PRESENZE(

    id_presenza INT AUTO_INCREMENT NOT NULL primary key, 
    id_cliente INT NOT NULL,
    data_inizio TIMESTAMP NOT NULL DEFAULT NOW(),
    data_fine TIMESTAMP NOT NULL DEFAULT NOW(),
    pres_isBYOD BOOLEAN NOT NULL,
    id_prenotazione INT NOT NULL,

    foreign key(id_cliente) references CLIENTI (id_cliente),
    foreign key (id_prenotazione) references PRENOTAZIONI (id_prenotazione)

);

create table EVENTI(

    id_evento INT AUTO_INCREMENT NOT NULL primary key,
    premio INT NOT NULL,
    prezzo_ing INT,
    data_inizio TIMESTAMP NOT NULL DEFAULT NOW(),
    data_fine TIMESTAMP NOT NULL DEFAULT NOW(),
    tema VARCHAR(100),
    descrizione VARCHAR(500)

);

create table PARTECIPANTI(

    id_evento INT NOT NULL,
    id_cliente INT NOT NULL,
    haPagato BOOLEAN,
    haPartecipato BOOLEAN,
    posizionamento VARCHAR(4),

    primary key(id_evento, id_cliente)

);