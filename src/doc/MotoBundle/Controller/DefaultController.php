<?php

namespace doc\MotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use doc\MotoBundle\Entity\Annonce;
use doc\MotoBundle\Entity\Moto;
use doc\MotoBundle\Entity\Departement;
use doc\MotoBundle\Form\AnnonceType;
use doc\MotoBundle\Form\AnnonceDeleteType;
use doc\MotoBundle\Form\AnnonceEditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class DefaultController extends Controller
{
    public function indexAction()
    {
		
		$repository = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('docMotoBundle:Annonce');

		$listeAnnonces = $repository->findByAutorisee(true);
		
		
        return $this->render('docMotoBundle:Default:index.html.twig', array('listeAnnonces' => $listeAnnonces));
    }
	
    public function ajouterAction(Request $request)
    {
		// On crée un objet Annonce
		$annonce = new Annonce();

		$form = $this->get('form.factory')->create(new AnnonceType, $annonce);
		
		$form->handleRequest($request);
		
		
		// On vérifie que les valeurs entrées sont correctes
		// (Nous verrons la validation des objets en détail dans le prochain chapitre)
		if ($form->isValid())
		{
		  $factory = $this->get('security.encoder_factory');
          $encoder = $factory->getEncoder($annonce);
          $password = $encoder->encodePassword($form->get('password')->getData(), $annonce->getSalt());
          $annonce->setPassword($password);
 
          		  
		  // On l'enregistre notre objet $annonce dans la base de données, par exemple
		  $em = $this->getDoctrine()->getManager();
		  $em->persist($annonce);
		  $em->flush();

		  $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

		  
		  // Envoi du mail
		  $message = \Swift_Message::newInstance()
			->setSubject('Valider votre annonce "'.$annonce->getTitre().'" sur Moto Echange')
			->setFrom('admin@moto-echange.com')
			->setTo($annonce->getMail())
			->setBody($this->renderView('docMotoBundle:Mails:valider.html.twig', array('lien' => $this->generateUrl('doc_moto_pageValider', array('code' => $annonce->getCodeValidation()), true))), 'text/html')
			;
			$this->get('mailer')->send($message);
		  
		  	  
		  return $this->redirect($this->generateUrl('doc_moto_accueil'));
		}

		// À ce stade, le formulaire n'est pas valide car :
		// - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
		// - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau
		return $this->render('docMotoBundle:Default:ajouter.html.twig', array('form' => $form->createView(), ));
    }
	
	public function editerAction($id, Request $request)
    {
		$annonce = $this->getDoctrine()
		  ->getManager()
		  ->getRepository('docMotoBundle:Annonce')
		  ->findOneBy(array('id' => $id, 'autorisee' => true))
		;

		if ($annonce == null)
		{
			throw new NotFoundHttpException('Page inexistante.');
		}
		
		
			

		
		$form = $this->get('form.factory')->create(new AnnonceEditType, $annonce);
		
		$form->handleRequest($request);
		
		
		// On vérifie que les valeurs entrées sont correctes
		if ($form->isValid())
		{
		  // On l'enregistre notre objet $annonce dans la base de données, par exemple
		  $em = $this->getDoctrine()->getManager();
		  $em->persist($annonce);
		  $em->flush();

		  $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

		  
		  
		  
		  // On redirige vers la page de visualisation de l'annonce nouvellement créée
		  return $this->redirect($this->generateUrl('doc_moto_annonce', array('id' => $annonce->getId())));
		}

		// À ce stade, le formulaire n'est pas valide car :
		// - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
		// - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau
		return $this->render('docMotoBundle:Default:editer.html.twig', array('form' => $form->createView(), ));
    }
	
	public function supprimerAction($id, Request $request)
    {
		
		$em = $this->getDoctrine()->getManager();

		// On récupère l'annonce $id
		$annonce = $em->getRepository('docMotoBundle:Annonce')->findOneBy(array('id' => $id, 'autorisee' => true));

		if (null === $annonce) {
			throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
		}
		
		
		$form = $this->get('form.factory')->create(new AnnonceDeleteType, $annonce);
		
		$form->handleRequest($request);
		
		
		// On vérifie que les valeurs entrées sont correctes
		// (Nous verrons la validation des objets en détail dans le prochain chapitre)
		if ($form->isValid())
		{
		  $em->remove($annonce);
		  $em->flush();

		  $request->getSession()->getFlashBag()->add('notice', 'Annonce supprimée.');

		  return $this->redirect($this->generateUrl('doc_moto_accueil'));
		}

		// À ce stade, le formulaire n'est pas valide car :
		// - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
		// - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau
		return $this->render('docMotoBundle:Default:supprimer.html.twig', array('form' => $form->createView(), 'annonce' => $annonce));
    }
	
    public function annoncescompatiblesAction()
    {
        return $this->render('docMotoBundle:Default:annoncescompatibles.html.twig');
    }
	
    public function annonceAction($id)
    {
		$repository = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('docMotoBundle:Annonce');

		$annonce = $repository->findOneBy(array('id' => $id, 'autorisee' => true));
		
        return $this->render('docMotoBundle:Default:annonce.html.twig', array('annonce' => $annonce));
    }
	
	public function pageValiderAction($code)
    {
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('docMotoBundle:Annonce');

		$annonce = $repository->findOneByCodeValidation($code);
		
		$em->persist($annonce);
		
		if (!$annonce == null)
		{
			$annonce->setValidee(true);
		}
		
		$em->flush();
		
        return $this->render('docMotoBundle:Default:pageValider.html.twig', array('annonce' => $annonce));
    }
	
	/**
    * @Security("has_role('ROLE_ADMIN')")
    */
	public function activerAction()
    {
		
		$repository = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('docMotoBundle:Annonce');

		$listeAnnonces = $repository->findBy(array('validee' => true, 'autorisee' => false));
		
        return $this->render('docMotoBundle:Default:activer.html.twig', array('listeAnnonces' => $listeAnnonces));
    }
}
