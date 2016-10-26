-----------------------------------------------------------------------
-- products
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [products];

CREATE TABLE [products]
(
    [id] INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    [title] VARCHAR(255) NOT NULL,
    [price] FLOAT(6,2) NOT NULL,
    UNIQUE ([id])
);

-----------------------------------------------------------------------
-- carts
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [carts];

CREATE TABLE [carts]
(
    [id] INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    UNIQUE ([id])
);

-----------------------------------------------------------------------
-- product_cart
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [product_cart];

CREATE TABLE [product_cart]
(
    [cart_id] INTEGER NOT NULL,
    [product_id] INTEGER NOT NULL,
    PRIMARY KEY ([cart_id],[product_id]),
    UNIQUE ([cart_id],[product_id])
);
