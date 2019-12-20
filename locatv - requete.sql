
-- 1. Créer une vue listant toutes les interventions avec le detail des données (contrat, client, installateur, appareil)
select *
from intervention, contrat, client, installateur, appareil
where int_contrat=con_id and int_installateur=ins_id and con_client=cli_id and con_appareil=app_id;

-- 2. Afficher la liste des interventions du 15 aout 2019
select * 
from intervention
where int_date="2019-08-15";

-- 3. Trouver la date qui comprend le plus d'interventions.
create or replace view NombreIntervention as 
select int_date, count(int_id) nb
from intervention
group by int_date
order by nb desc;

select  int_date,nb 
from NombreIntervention
where nb=(select max(nb) from NombreIntervention);

-- 4. Trouver l'appareil le plus louée, en terme de nombre de contrat.
create or replace view NombreContrat as 
select con_appareil, count(con_id) nb
from contrat
group by con_appareil
order by nb desc;

select  con_appareil,nb 
from NombreContrat
where nb=(select max(nb) from NombreContrat);

-- 5. Trouver l'appareil le plus louée, en terme de durée de contrat.
create or replace view DureeContrat as 
select con_appareil, sum(datediff(con_date_fin,con_date_debut)) nb
from contrat
group by con_appareil
order by nb desc;

select  con_appareil,nb 
from DureeContrat
where nb=(select max(nb) from DureeContrat);

-- 6. Calculer le nombre totale d'interventions par installateur.
select ins_nom,int_installateur,count(int_id)
from intervention, installateur
where int_installateur=ins_id
group by int_installateur;

-- 7. Calculer le nombre totale d'interventions par installateur et par type d'intervention.
select ins_nom,int_installateur,int_type, count(int_id) nb
from intervention, installateur
where int_installateur=ins_id
group by int_installateur,int_type ;

-- 8. Calculer le nombre totale d'interventions par installateur et par mois.
select ins_nom,int_installateur,month(int_date), count(int_id) nb
from intervention, installateur
where int_installateur=ins_id
group by int_installateur,month(int_date) ;

-- 9. Lister les contrats en cours à la date du 15 aout 2019.
select * 
from contrat
where '2019-08-15'>=con_date_debut and '2019-08-15'<=con_date_fin

select * 
from contrat
where '2019-08-15' between con_date_debut and con_date_fin

-- 10. Lister les appareils en location à la date du 15 aout 2019.
select app_id, app_marque
from contrat, appareil
where con_appareil=app_id and '2019-08-15' between con_date_debut and con_date_fin

-- 11. Lister les appareils non loués entre 2 dates données.
-- 11a. Lister les appareils loués entre 2 dates données, d1 et d2. (2019-08-01 et 2019-08-15)
-------------------------d1-----------------------d2---------------------------------
------------------------------DEBUT----------FIN--------------------------------------
select app_id, app_marque
from appareil
where app_id not in (
    select con_id
    from contrat
    where con_date_debut<=d2 and con_date_fin>=d1);
