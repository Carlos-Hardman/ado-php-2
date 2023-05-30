CREATE TABLE quarto (
  numero INTEGER NOT NULL PRIMARY KEY,
  camas_solteiro INTEGER NOT NULL CHECK (camas_solteiro >= 0),
  camas_casal INTEGER NOT NULL CHECK (camas_casal >= 0),
  area_m2 INTEGER NOT NULL CHECK (area_m2 > 0),
  reservado INTEGER NOT NULL CHECK (reservado = 0 OR reservado = 1),
  valor_diaria INTEGER NOT NULL CHECK (valor_diaria > 0)
);
