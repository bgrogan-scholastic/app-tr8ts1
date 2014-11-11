
__author__ = "Todd Reisel"
__date__ = "August 31, 2004"

""" This object should be derived from GI_Transform, it is a test module. """
from GI_Transform import *;

class GI_Transform_Passwd(GI_Transform):
	""" The GI_Tranform_Passwd object derives from GI_Transform, this 
	is a test module that simply appends some content to the input buffer. """
	
	def __init__(self, inputBuffer):
		""" Parameters: inputBuffer - a python string that will get transformed. """
		GI_Transform.__init__(self, 'passwd', inputBuffer);

	def _process(self):
		""" The _process method is the template pattern method that will
		get called by the GI_Transform::process method, this method should transform the text,
		set its self._outputBuffer to the new content and return. """
		self._outputBuffer = self._inputBuffer + 'processed content';

if __name__ == '__main__':
	myTransform = GI_Transform_Passwd('test content');
	print myTransform.process();
	
