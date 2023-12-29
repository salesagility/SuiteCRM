-- insert new validation action
ALTER TABLE stic_payment_commitments   
add COLUMN IF NOT EXISTS redsys_ds_merchant_identifier varchar(255)  NULL ,  
add COLUMN IF NOT EXISTS redsys_ds_merchant_cof_txnid varchar(255)  NULL ,  
add COLUMN IF NOT EXISTS card_expiry_date varchar(4)  NULL ,  
add COLUMN IF NOT EXISTS paypal_subscr_id varchar(30)  NULL ;