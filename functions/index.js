const functions = require('firebase-functions');
const stripe = require('stripe')(functions.config().stripe.key);
const cors = require('cors')({origin: true});

async function createSession(req, res) {
  const session = await stripe.checkout.sessions.create({
    payment_method_types: ['card'],
    line_items: req.body,
    success_url: 'https://comp-server.uhi.ac.uk/~15027887/methods/checkout.php',
    cancel_url: 'https://comp-server.uhi.ac.uk/~15027887/pages/cart'
  });
  return session;
}

exports.createSession = functions.https.onRequest(async (req, res) => {
  cors(req, res, async () => {
    res.status(200).send(await createSession(req));
  });
});

