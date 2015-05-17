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
use doc\MotoBundle\Form\PasswordType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
		
		$repository = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('docMotoBundle:Annonce');

		//$listeAnnonces = $repository->findByAutorisee(true);
		$listeAnnonces = $repository->findBy(
			array('autorisee' => true),
			array('date' => 'asc')
		);
		
		
		$messagesTableau = $request->getSession()->getFlashBag()->get('notice');
		
		$message = end($messagesTableau);
		
		
        return $this->render('docMotoBundle:Default:index.html.twig', array('listeAnnonces' => $listeAnnonces, 'message' => $message));
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
 
          		  
		  // On enregistre notre objet $annonce dans la base de données, par exemple
		  $em = $this->getDoctrine()->getManager();
		  $em->persist($annonce);
		  $em->flush();

		  $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée. Vous allez recevoir un mail pour la valider.');

		  
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
		
		$form2 = $this->createForm(new PasswordType());
		$form2->handleRequest($request);
		
		$factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($annonce);	
		
		$passwordCorrect = $annonce->getPassword() === $encoder->encodePassword($form2->get('password')->getData(), $annonce->getSalt());
		if (($form2->isValid() AND $passwordCorrect == true) OR $form->isValid())
		{
			
			// On vérifie que les valeurs entrées sont correctes
			if ($form->isValid())
			{
			  // On enregistre notre objet $annonce dans la base de données, par exemple
			  $em = $this->getDoctrine()->getManager();
			  $em->persist($annonce);
			  $em->flush();

			  $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

			  		  
			  // On redirige vers la page de visualisation de l'annonce nouvellement modifiée
			  return $this->redirect($this->generateUrl('doc_moto_annonce', array('id' => $annonce->getId())));
			}

			// À ce stade, le formulaire n'est pas valide car :
			// - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
			// - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau
			return $this->render('docMotoBundle:Default:editer.html.twig', array('form' => $form->createView(), 'passwordOk' => true ));
			
		}
		else
		{
			if ($form2->get('password')->getData() != null)
			{
				$messageErreur = 'Mot de passe incorrect';
			}
			else
			{
				$messageErreur = null;
			}
			
			return $this->render('docMotoBundle:Default:editer.html.twig', array('form2' => $form2->createView(), 'annonce' => $annonce, 'passwordOk' => false, 'messageErreur' => $messageErreur));
		}
    }
	
	public function supprimerAction($id, Request $request)
    {
		
		$em = $this->getDoctrine()->getManager();

		// On récupère l'annonce $id
		$annonce = $em->getRepository('docMotoBundle:Annonce')->findOneBy(array('id' => $id, 'autorisee' => true));

		if (null === $annonce) {
			throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
		}
		
		
		$form = $this->get('form.factory')->create(new PasswordType);
		
		$form->handleRequest($request);
		
		$factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($annonce);	
		
		
		// On vérifie que les valeurs entrées sont correctes
		// (Nous verrons la validation des objets en détail dans le prochain chapitre)
		$passwordCorrect = $annonce->getPassword() === $encoder->encodePassword($form->get('password')->getData(), $annonce->getSalt());
		
		if ($form->isValid() AND $passwordCorrect == true)
		{
		  $em->remove($annonce);
		  $em->flush();

		  $request->getSession()->getFlashBag()->add('notice', 'Annonce supprimée.');

		  return $this->redirect($this->generateUrl('doc_moto_accueil'));
		}

		if ($form->get('password')->getData() != null)
		{
			$messageErreur = 'Mot de passe incorrect';
		}
		else
		{
			$messageErreur = null;
		}
		
		
		// À ce stade, le formulaire n'est pas valide car :
		// - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
		// - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau
		return $this->render('docMotoBundle:Default:supprimer.html.twig', array('form' => $form->createView(), 'annonce' => $annonce, 'messageErreur' => $messageErreur));
    }
	
    public function annoncescompatiblesAction($id)
    {
		$repository = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('docMotoBundle:Annonce');

		$listeAnnonces = $repository->getAnnoncesCompatibles($id);
		
		
        return $this->render('docMotoBundle:Default:annoncescompatibles.html.twig', array('listeAnnonces' => $listeAnnonces));
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
	public function activerAction($id)
    {
		
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('docMotoBundle:Annonce');
		
		if ($id > 0)
		{
			$annonce = $repository->find($id);
			$em->persist($annonce);
			$annonce->setAutorisee(true);
			$em->flush();
		}
		
			
		$listeAnnonces = $repository->findBy(array('validee' => true, 'autorisee' => false));
		
		if ($id == -1)
		{
			foreach ($listeAnnonces as $annonce)
			{
				$em->persist($annonce);
				$annonce->setAutorisee(true);
				$em->flush();
			}
			
			return $this->render('docMotoBundle:Default:activer.html.twig', array('listeAnnonces' => null));
		}
		
        return $this->render('docMotoBundle:Default:activer.html.twig', array('listeAnnonces' => $listeAnnonces));
    }
	
}
