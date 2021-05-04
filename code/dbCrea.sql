create table CLIENTI
(

    email VARCHAR(50) NOT NULL primary key,
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
    data_fine TIMESTAMP DEFAULT NOW(),
    email VARCHAR(50) NOT NULL,
    postazione_pren CHAR(1),
    data_pren TIMESTAMP DEFAULT NOW(),
    is_closed BOOLEAN,

    foreign key(email) references CLIENTI (email)
    
);


create table PRESENZE(

    id_presenza INT AUTO_INCREMENT NOT NULL primary key, 
    email VARCHAR(50) NOT NULL,
    data_inizio TIMESTAMP NOT NULL DEFAULT NOW(),
    data_fine TIMESTAMP NOT NULL DEFAULT NOW(),
    pres_isBYOD BOOLEAN NOT NULL,
    id_prenotazione INT NOT NULL,

    foreign key (email) references CLIENTI (email),
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
    email VARCHAR(50) NOT NULL,
    haPagato BOOLEAN,
    haPartecipato BOOLEAN,
    posizionamento VARCHAR(4),

    primary key(id_evento, email)

);