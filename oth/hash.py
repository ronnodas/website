import hashlib

def h1(s):
	s = s.encode('ascii')
	s = hashlib.sha256(s).hexdigest()
	s = s + 'Viswambhara'
	s = s.encode('ascii')
	s = hashlib.sha256(s).hexdigest()
	return s

def h2(s):
	s = s.encode('ascii')
	s = hashlib.sha256(s).hexdigest()
	s = s + 'JackSparrow'
	s = s.encode('ascii')
	s = hashlib.sha256(s).hexdigest()
	return s

def h(s):
	print(h1(s))
	print(h2(s))

