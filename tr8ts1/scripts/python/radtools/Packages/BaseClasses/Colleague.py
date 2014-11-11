
# this is the base class colleague, implemented
# as a template pattern. your controls on the form/dialog box/panel should
# inherit from this
class Colleague:
    def __init__(self, mediator):
        self.mediator = mediator

    def Changed(self, colleague, event):
        """Template pattern interface method, intended to be called directly"""
        self._Changed(colleague, event)

    def _Changed(self, colleague, event):
        """Template pattern interface method, intended to be inherited"""
        self.mediator.ColleagueChanged(colleague, event)


