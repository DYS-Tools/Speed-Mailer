<?php

namespace App\Controller;


use App\Entity\Ticket;
use App\Form\TicketType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Require ROLE_USER for *every* controller method in this class.
 * @IsGranted("ROLE_USER")
 */
class DashboardUserController extends AbstractController
{
    /**
     * @Route("/dashboard/user", name="app_dashboard_user")
     */
    public function index()
    {
        return $this->render('dashboard/user/dashboardUser.html.twig', [
        ]);
    }

    /**
     * @Route("/dashboard/user/ticket", name="app_dashboard_user_ticket")
     */
    public function createTicket(Request $request)
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        // get current user
        $user = $this->getUser() ;

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // add Author for this ticket
            $user = $this->getUser() ;
            $ticket->setUser($user);
            $ticket->setCreatedAt(new \DateTime());
            $ticket->setState(1);

            $em->persist($ticket);
            $em->flush();

            $this->addFlash('Ticket','Votre demande a bien été prise en compte.');
        }

        return $this->render('dashboard/user/ticket.html.twig', [
            'form' => $form->createView(),
            'ticketUserOpen' => $this->getDoctrine()->getRepository(Ticket::class)->findTicketOpenUser($user),
            'ticketUserClose' => $this->getDoctrine()->getRepository(Ticket::class)->findTicketCloseUser($user),
            'countTicketUserOpen' => $this->getDoctrine()->getRepository(Ticket::class)->countTicketOpenUser($user),
            'countTicketUserClose' => $this->getDoctrine()->getRepository(Ticket::class)->countTicketCloseUser($user),
        ]);
    }
}
