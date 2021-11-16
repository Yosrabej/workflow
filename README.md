Activité 4.11.3 : Nous avons des process
Description	
Commencez un nouveau projet Symfony pour attaquer le beau morceau qui est le workflow.

Créez le workflow d’une commande sur un site d’e-commerce avec les étapes suivantes :

La commande est passée
La commande est annulée
Le paiement de la commande est validé
La commande est expédiée
La commande a été livrée
Les règles sont les suivantes :

Une commande peut être annulée tant qu’elle n’est pas expédiée
Le paiement de la commande ne peut être validé qu’une fois que la commande est passée
La commande ne peut être expédiée que lorsque le paiement est validé
Le statut « Livré » n’a de sens que si la commande a été expédiée auparavant.
Codez un site simple qui met en œuvre ce workflow.

Les étapes comme la validation du paiement, l’expédition ou la livraison seront à appliquer via un panel admin.