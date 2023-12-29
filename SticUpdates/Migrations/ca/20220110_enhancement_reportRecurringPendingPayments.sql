-- Rename validation action
UPDATE
    stic_validation_actions
SET
    name = 'Compromisos de pagament - Revisió de les autoritzacions recurrents incompletes'
where
    id = 'ac28533e-40ad-11ec-b2f2-0242ac150002'
